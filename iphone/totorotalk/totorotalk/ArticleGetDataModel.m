//
//  ArticleGetDataModel.m
//  totorotalk
//
//  Created by lee will on 12-3-11.
//  Copyright (c) 2012年 __MyCompanyName__. All rights reserved.
//

#import "ArticleGetDataModel.h"
#import "Article.h"
#import <extThree20JSON/extThree20JSON.h>

static NSString* api = @"http://www.timepic.net/totorotalk/api/Article/list/";
//static NSString* api = @"http://test.timepic.net/totorotalk/api/Article/list/";

@implementation ArticleGetDataModel

@synthesize searchQuery     = _searchQuery;
@synthesize queryValue     = _queryValue;
@synthesize datas          = _datas;
@synthesize resultsPerPage  = _resultsPerPage;
@synthesize finished        = _finished;



///////////////////////////////////////////////////////////////////////////////////////////////////
- (id)initWithSearchQuery:(NSString*)searchQuery andQueryValue:(NSString *)QueryValue {
	if (self = [super init]) {
		self.searchQuery = searchQuery;
		self.queryValue	= QueryValue;
		_datas = [[NSMutableArray array] retain];
		if(searchQuery == @"page") {
			_page = [QueryValue intValue];
		}
		if(searchQuery == @"Jid"){
			//[super load:TTURLRequestCachePolicy more:NO];
		}
	}
	
	return self;
}


///////////////////////////////////////////////////////////////////////////////////////////////////
- (void) dealloc {
	TT_RELEASE_SAFELY(_searchQuery);
	TT_RELEASE_SAFELY(_queryValue);
	TT_RELEASE_SAFELY(_datas);
	[super dealloc];
}


///////////////////////////////////////////////////////////////////////////////////////////////////
- (void)load:(TTURLRequestCachePolicy)cachePolicy more:(BOOL)more {
	if (!self.isLoading && TTIsStringWithAnyText(_searchQuery)) {
		if (more) {
			_page++;
		}
		else {
			_page = 1;
			_finished = NO;
			[_datas removeAllObjects];
		}
		
		NSString* url = [NSString stringWithFormat:api, _searchQuery, _queryValue];
        
		TTURLRequest* request = [TTURLRequest
								 requestWithURL: url
								 delegate: self];
        
		request.httpMethod = @"GET";//debug
		request.cachePolicy = cachePolicy;
		request.cacheExpirationAge = TT_CACHE_EXPIRATION_AGE_NEVER;
		
		TTURLJSONResponse* response = [[TTURLJSONResponse alloc] init];
		request.response = response;
		TT_RELEASE_SAFELY(response);
		
		[request send];
	}
}


///////////////////////////////////////////////////////////////////////////////////////////////////
- (void)requestDidFinishLoad:(TTURLRequest*)request {
	TTURLJSONResponse* response = request.response;
	TTDASSERT([response.rootObject isKindOfClass:[NSDictionary class]]);
	
	NSDictionary* datas = response.rootObject;
	TTDASSERT([[datas objectForKey:@"datas"] isKindOfClass:[NSArray class]]);
	
	NSArray* entries = [datas objectForKey:@"datas"];
	//用来转换时间 从string 到 nsdate
	NSDateFormatter* dateFormatter = [[NSDateFormatter alloc] init];
	[dateFormatter setTimeStyle:NSDateFormatterFullStyle];
	[dateFormatter setDateFormat:@"yyyy-MM-dd HH:mm:ss"];
	
	NSMutableArray* items = [NSMutableArray arrayWithCapacity:[entries count]];
	
	for (NSDictionary* entry in entries) {
		Article* article = [[Article alloc] init];
		article.dateline =[dateFormatter dateFromString:[entry objectForKey:@"dateline"]];
		article.articleTitle = [entry objectForKey:@"title"];
		article.articleId = [NSNumber numberWithLongLong:
                       [[entry objectForKey:@"id"] longLongValue]];
		article.articleContent = [entry objectForKey:@"content"];
		article.articleImage = [entry objectForKey:@"imgurl"];		
		[items addObject:article];
		TT_RELEASE_SAFELY(article);
	}

	_finished = items.count < _resultsPerPage;
	[_datas addObjectsFromArray: items];
	
	TT_RELEASE_SAFELY(dateFormatter);
	[super requestDidFinishLoad:request];
}



@end
