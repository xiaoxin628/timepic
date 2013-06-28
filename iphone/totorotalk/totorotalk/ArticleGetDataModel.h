//
//  ArticleGetDataModel.h
//  totorotalk
//
//  Created by lee will on 12-3-11.
//  Copyright (c) 2012年 __MyCompanyName__. All rights reserved.
//

#import <Three20/Three20.h>

@interface ArticleGetDataModel : TTURLRequestModel{
	NSString* _searchQuery;
	
	NSMutableArray*  _datas;
	
	NSUInteger _page;             // page of search request
	NSUInteger _resultsPerPage;
	//searchQuery的值
	NSString* _queryValue;
	
	BOOL _finished;
}
@property (nonatomic, copy)     NSString*       searchQuery;
@property (nonatomic, copy)     NSString*       queryValue;
@property (nonatomic, readonly) NSMutableArray* datas;
@property (nonatomic, assign)   NSUInteger      resultsPerPage;
@property (nonatomic, readonly) BOOL            finished;

- (id)initWithSearchQuery:(NSString*)searchQuery andQueryValue:(NSString *)QueryValue;
@end
