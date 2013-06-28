//
//  CameraController.h
//  totorotalk
//
//  Created by lee will on 12-3-27.
//  Copyright (c) 2012年 __MyCompanyName__. All rights reserved.
//

#import <Three20/Three20.h>
#import <extThree20JSON/extThree20JSON.h>

@interface CameraController : TTViewController <UINavigationControllerDelegate, UIImagePickerControllerDelegate,UIActionSheetDelegate>{
	int hideMenu;
}

@property int hideMenu;
- (UIImage*)imageByScalingAndCroppingForSize:(CGSize)targetSize sourceFromImage:(UIImage*) sourceImage;
@end

