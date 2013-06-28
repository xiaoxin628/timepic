//
//  HotPhotoGetDataModel.h
//  totorotalk
//
//  Created by lee will on 12-4-14.
//  Copyright (c) 2012年 __MyCompanyName__. All rights reserved.
//

#import <Three20/Three20.h>
#import <extThree20JSON/extThree20JSON.h>
#import "HotPhoto.h"
@interface HotPhotoGetDataModel : TTURLRequestModel {
	NSString* _searchQuery;
	
	NSMutableArray*  _photos;
	
	NSUInteger _page;             // page of search request
	NSUInteger _resultsPerPage;
	//searchQuery的值
	NSString* _queryValue;
	
	BOOL _finished;
}

@property (nonatomic, copy)     NSString*       searchQuery;
@property (nonatomic, copy)     NSString*       queryValue;
@property (nonatomic, retain) NSMutableArray* photos;
@property (nonatomic, assign)   NSUInteger      resultsPerPage;
@property (nonatomic, readonly) BOOL            finished;

- (id)initWithSearchQuery:(NSString*)searchQuery andQueryValue:(NSString *)QueryValue;

@end