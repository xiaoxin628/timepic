//
//  HotPhoto.h
//  totorotalk
//
//  Created by lee will on 12-4-14.
//  Copyright (c) 2012年 __MyCompanyName__. All rights reserved.
//
#import <Three20/Three20.h>

@interface HotPhoto : NSObject <TTPhoto> {
    id<TTPhotoSource> _photoSource;
    NSString* _thumbURL;
    NSString* _smallURL;
    NSString* _URL;
    CGSize _size;
    NSInteger _index;
    NSString* _caption;
}

- (id)initWithURL:(NSString*)URL smallURL:(NSString*)smallURL size:(CGSize)size;

- (id)initWithURL:(NSString*)URL smallURL:(NSString*)smallURL size:(CGSize)size
caption:(NSString*)caption;
@end