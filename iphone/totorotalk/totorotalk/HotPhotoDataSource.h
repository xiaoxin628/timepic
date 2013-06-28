//
//  HotPhotoDataSource.h
//  totorotalk
//
//  Created by lee will on 12-4-14.
//  Copyright (c) 2012年 __MyCompanyName__. All rights reserved.
//

#import <Three20/Three20.h>
#import "HotPhotoGetDataModel.h"
#import "HotPhoto.h"
typedef enum {
    HotPhotoSourceNormal = 0,
    HotPhotoSourceDelayed = 1,
    HotPhotoSourceVariableCount = 2,
    HotPhotoSourceLoadError = 4,
} HotPhotoSourceType;

@interface HotPhotoDataSource: TTURLRequestModel <TTPhotoSource>{
    HotPhotoGetDataModel *_searchDataModel;
    NSString* _title;
    NSMutableArray* _photos;
	NSUInteger _page;             // page of search request
    
}


- (id)initWithSearchQuery:(NSString*)searchQuery andQueryValue:(NSString *)QueryValue;

@end
