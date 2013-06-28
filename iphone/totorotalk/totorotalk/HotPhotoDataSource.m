//
//  HotPhotoDataSource.m
//  totorotalk
//
//  Created by lee will on 12-4-14.
//  Copyright (c) 2012年 __MyCompanyName__. All rights reserved.
//

#import "HotPhotoDataSource.h"


@implementation HotPhotoDataSource

@synthesize title = _title;

///////////////////////////////////////////////////////////////////////////////////////////////////
- (id)initWithSearchQuery:(NSString*)searchQuery andQueryValue:(NSString *)QueryValue{
	if (self = [super init]) {
		_searchDataModel = [[HotPhotoGetDataModel alloc] initWithSearchQuery:searchQuery andQueryValue:QueryValue];

        _title = self.title;
        _photos = [_searchDataModel.photos mutableCopy] ;
		
        if(searchQuery == @"page") {
			_page = [QueryValue intValue];
		}
        for (int i = 0; i < _photos.count; ++i) {
            id<TTPhoto> photo = [_photos objectAtIndex:i];
            if ((NSNull*)photo != [NSNull null]) {
                photo.photoSource = self;
                photo.index = i;
            }
        }
	}
	
	return self;
}



///////////////////////////////////////////////////////////////////////////////////////////////////
- (void)dealloc {
    TT_RELEASE_SAFELY(_searchDataModel);
    TT_RELEASE_SAFELY(_photos);
    TT_RELEASE_SAFELY(_title);
    [super dealloc];
}


- (BOOL)isLoading {
    return !!_photos;
}

- (BOOL)isLoaded {
    return !!_photos;
}

//加载更多照片
- (void)load:(TTURLRequestCachePolicy)cachePolicy more:(BOOL)more {
    if (cachePolicy & TTURLRequestCachePolicyNetwork) {
        NSLog(@"loadmore");
        [_delegates perform:@selector(modelDidStartLoad:) withObject:self];
        
        TT_RELEASE_SAFELY(_photos);
        if (more) {
			_page++;
		}
		else {
			_page = 1;
			[_photos removeAllObjects];
		}
        NSLog(@"%d",_page);

        [self initWithSearchQuery:@"page" andQueryValue:[NSString stringWithFormat:@"%d", _page]];

        [_delegates perform:@selector(modelDidFinishLoad:) withObject:self];
    }
}


///////////////////////////////////////////////////////////////////////////////////////////////////
- (id<TTModel>)model {
    return _searchDataModel;
}


///////////////////////////////////////////////////////////////////////////////////////////////////
// TTPhotoSource

- (NSInteger)numberOfPhotos {
    if (_photos.count <20) {
        return _photos.count;
    }else if (_searchDataModel.resultsPerPage) {
        return _searchDataModel.resultsPerPage*(_photos.count);
    }else{
        return 20;
    }
}

- (NSInteger)maxPhotoIndex {
    return _photos.count-1;
}

- (id<TTPhoto>)photoAtIndex:(NSInteger)photoIndex {
    NSLog(@"%d", photoIndex);
    if (photoIndex < _photos.count) {
        id photo = [_photos objectAtIndex:photoIndex];
        if (photo == [NSNull null]) {
            return nil;
        } else {
            return photo;
        }
    } else {
        return nil;
    }
}


@end
