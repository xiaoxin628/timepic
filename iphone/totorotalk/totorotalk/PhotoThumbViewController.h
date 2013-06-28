//
//  PhotoThumbViewController.h
//  totorotalk
//
//  Created by lee will on 12-4-4.
//  Copyright (c) 2012年 __MyCompanyName__. All rights reserved.
//

#import <Three20/Three20.h>
#import <extThree20JSON/extThree20JSON.h>
//#import "HotPhotoDataSource.h"
#import "MockPhotoSource.h"

@interface PhotoThumbViewController : TTThumbsViewController{
    NSMutableArray* hotPhotos;
}

@end
