//
//  HotPhotoGetDataModel.m
//  totorotalk
//
//  Created by lee will on 12-4-14.
//  Copyright (c) 2012年 __MyCompanyName__. All rights reserved.
//

#import "HotPhotoGetDataModel.h"

static        NSString* api  = @"http://www.timepic.net/totorotalk/api/photo/photolist/%@/%@/key/fa299ad0fc857f005b03fb5670d1e2ca";


@implementation HotPhotoGetDataModel


@synthesize searchQuery     = _searchQuery;
@synthesize queryValue     = _queryValue;
@synthesize photos          = _photos;
@synthesize resultsPerPage  = _resultsPerPage;
@synthesize finished        = _finished;

///////////////////////////////////////////////////////////////////////////////////////////////////
- (id)initWithSearchQuery:(NSString*)searchQuery andQueryValue:(NSString *)QueryValue {
	if (self = [super init]) {
		self.searchQuery = searchQuery;
		self.queryValue	= QueryValue;
		_photos = [[NSMutableArray array] retain];
        
        if(searchQuery == @"page") {
			_page = [QueryValue intValue];
		}
        
        [self getPhotosList];
	}
	
	return self;
}


///////////////////////////////////////////////////////////////////////////////////////////////////
- (void) dealloc {
	TT_RELEASE_SAFELY(_searchQuery);
	TT_RELEASE_SAFELY(_queryValue);
	TT_RELEASE_SAFELY(_photos);
	[super dealloc];
}


///////////////////////////////////////////////////////////////////////////////////////////////////
- (void)getPhotosList {
	if (!self.isLoading && TTIsStringWithAnyText(_searchQuery)) {
		NSString* url = [NSString stringWithFormat:api, _searchQuery, _queryValue];
//        NSLog(@"%@", url);
		TTURLRequest* request = [TTURLRequest
								 requestWithURL: url
								 delegate: self];
//		NSMutableDictionary *parameter = [[NSMutableDictionary alloc] initWithObjectsAndKeys:@"key",@"fa299ad0fc857f005b03fb5670d1e2ca", nil];

		request.httpMethod = @"GET";//debug
		request.cachePolicy = TTURLRequestCachePolicyNetwork;
		request.cacheExpirationAge = TT_CACHE_EXPIRATION_AGE_NEVER;
		
		TTURLJSONResponse* response = [[TTURLJSONResponse alloc] init];
		request.response = response;
		TT_RELEASE_SAFELY(response);

		[request sendSynchronously];
	}
}


///////////////////////////////////////////////////////////////////////////////////////////////////
- (void)requestDidFinishLoad:(TTURLRequest*)request {
	TTURLJSONResponse* response = request.response;
	TTDASSERT([response.rootObject isKindOfClass:[NSDictionary class]]);
	
	NSDictionary* datas = response.rootObject;
	TTDASSERT([[datas objectForKey:@"datas"] isKindOfClass:[NSArray class]]);
	
    _resultsPerPage = [[datas objectForKey:@"total"] intValue];
    
	NSArray* entries = [datas objectForKey:@"datas"];

    NSMutableArray * Mphotos = [[NSMutableArray alloc] init];
	
	for (NSDictionary* entry in entries) {
        HotPhoto *photo = [[[HotPhoto alloc] 
                             initWithURL:[entry objectForKey:@"image"]
                             smallURL:[entry objectForKey:@"thumb"]
                             size:CGSizeMake(320, 480)] autorelease];
        [Mphotos addObject:photo];
        TT_RELEASE_SAFELY(photo);
	}
	_finished = Mphotos.count < _resultsPerPage;
	[_photos addObjectsFromArray: Mphotos];
	NSLog(@"request");
	[super requestDidFinishLoad:request];
}

// TTModel



- (BOOL)isLoaded {
    return !!_photos;
}



@end
