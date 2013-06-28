//
//  CameraController.m
//  totorotalk
//
//  Created by lee will on 12-3-27.
//  Copyright (c) 2012年 __MyCompanyName__. All rights reserved.
//

#import "CameraController.h"

@implementation CameraController
@synthesize hideMenu;
static        NSString* api  = @"http://www.timepic.net/totorotalk/api/photo/uploadPhoto";

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        //设置导航栏背景色
        self.navigationBarTintColor = [UIColor blackColor];
        self.title = TTLocalizedString(@"camera", @"camera");
        //tabbar 设置样式
        UIImage* tabimg = [UIImage imageNamed:@"tab.png"];
        self.tabBarItem = [[[UITabBarItem alloc] initWithTitle:@"" image:tabimg tag:0] autorelease];
        [self.tabBarItem setFinishedSelectedImage:tabimg withFinishedUnselectedImage:tabimg];
        //设置tabbarbutton 文本颜色
        [self.tabBarItem setTitleTextAttributes:[NSDictionary dictionaryWithObjectsAndKeys:[UIColor colorWithRed:0 green:0 blue:0 alpha:1.0],UITextAttributeTextColor, nil] forState:UIControlStateNormal];
        //    UIView *CameraView = [[[UIView alloc] initWithFrame:TTNavigationFrame()] autorelease];
        //    self.view = CameraView;
    }
    return self;
}
-(void)viewDidAppear:(BOOL)animated{
    [self uploadPhotoView:@"upload"];
}

- (void)loadView {

}

//弹出选择框 如果没有自定义的uiview 则无法家在uiactionsheet
- (id)uploadPhotoView:(NSString *) action
{
    if (self = [super init]) {
        UIView *view = [[ UIView alloc] initWithFrame:[UIScreen mainScreen].applicationFrame] ;
        [ view setBackgroundColor:[UIColor blackColor]] ;
        self.view = view;
        
        UIActionSheet *menu = [[UIActionSheet alloc]
                               initWithTitle: @"选取照片"
                               delegate:self
                               cancelButtonTitle:@"取消"
                               destructiveButtonTitle:@"相机"
                               otherButtonTitles:@"本地相册", nil];
//        [menu showFromTabBar:self.tabBarController.tabBar];
        [menu showInView:self.view];
    }
    return self;
}
-(void)actionSheetCancel:(UIActionSheet *)actionSheet{
  TTOpenURL(@"tt://totoroTalk");
}

//根据选择值调用相应的acton
-(void)actionSheet:(UIActionSheet *)actionSheet clickedButtonAtIndex:(NSInteger)buttonIndex{
    switch (buttonIndex) {
        case 0:
            [self takePhoto];
            break;
        case 1:
            [self selectPhoto];
            break;
        case 2:
            TTOpenURL(@"tt://totoroTalk");
            break;
        default:
            TTOpenURL(@"tt://totoroTalk");
            break;
    }
}
//选择相片
- (void)selectPhoto
{
    UIImagePickerController *picker = [[UIImagePickerController alloc] init];
    picker.sourceType = UIImagePickerControllerSourceTypePhotoLibrary;
    picker.delegate = self;
    [self presentModalViewController:picker animated:YES];
    [picker release];
}

//拍摄照片
- (void)takePhoto
{
    UIImagePickerController *picker = [[UIImagePickerController alloc] init];
    picker.sourceType = UIImagePickerControllerSourceTypeCamera;
    picker.delegate = self;
    [self presentModalViewController:picker animated:YES];
    [picker release];
}
//选择图片

-(void)imagePickerController:(UIImagePickerController *)picker didFinishPickingMediaWithInfo:(NSDictionary *)info{

    NSString *mediaType = [info objectForKey: UIImagePickerControllerMediaType];
    
    UIImage *originalImage, *editedImage, *imageToSave, *resizeImage;
    
    
    // Handle a still image capture
    
    if ([mediaType isEqualToString: @"public.image"]) {
        
        editedImage = (UIImage *) [info objectForKey: @"UIImagePickerControllerEditedImage"];
        
        originalImage = (UIImage *) [info objectForKey: @"UIImagePickerControllerOriginalImage"];

        if (editedImage) {
            imageToSave = editedImage;
        } else {
            imageToSave = originalImage;
        }
        resizeImage = [self imageByScalingAndCroppingForSize:CGSizeMake(640, 960) sourceFromImage:imageToSave];
        NSLog(@"%@",originalImage);
        // Save the new image (original or edited) to the Camera Roll
        
        UIImageWriteToSavedPhotosAlbum (imageToSave, nil, nil , nil);
        NSLog(@"pick");
        [self dismissModalViewControllerAnimated:YES];
        [self uploadTototroPhoto:resizeImage];
    }

    TTOpenURL(@"tt://totoroTalk");
    
}
//取消选择图片
- (void)imagePickerControllerDidCancel:(UIImagePickerController *)picker
{
    NSLog(@"cancel");
    [self dismissModalViewControllerAnimated:YES];    
    TTOpenURL(@"tt://totoroTalk");
	
}
//上传图片
- (void)uploadTototroPhoto:(UIImage *)photo
{
    
    
    TTURLRequest* request = [TTURLRequest
                             requestWithURL: api
                             delegate: self];
    request.cachePolicy = TTURLRequestCachePolicyNone;
    request.httpMethod = @"POST";
    request.cacheExpirationAge = TT_CACHE_EXPIRATION_AGE_NEVER;
    [request.parameters setObject:@"totoroPhoto" forKey:@"title"];
    [request addFile:UIImageJPEGRepresentation(photo, 1) mimeType:@"image/jpeg"  fileName:@"TotorotalkPhoto[totoroPhoto]"];
    TTURLJSONResponse* response = [[TTURLJSONResponse alloc] init];
    request.response = response;
    TT_RELEASE_SAFELY(response);
    [request send];
}

//上传图片回调函数
///////////////////////////////////////////////////////////////////////////////////////////////////
- (void)requestDidFinishLoad:(TTURLRequest*)request {
    NSString *alertTitle;
    NSString *alertMsg;
	TTURLJSONResponse* response = request.response;
	TTDASSERT([response.rootObject isKindOfClass:[NSDictionary class]]);
	
	NSDictionary* datas = response.rootObject;
	TTDASSERT([[datas objectForKey:@"datas"] isKindOfClass:[NSArray class]]);
	
	NSArray* entries = [datas objectForKey:@"datas"];
    NSString *result = [[entries objectAtIndex:0] objectForKey: @"code"];
    if ([result isEqualToString:@"1"]) {
        alertTitle = @"提示";
        alertMsg = @"上传成功";
    }else{
        alertTitle = @"提示";
        alertMsg = @"上传失败";
    }
    UIAlertView *alert = [[UIAlertView alloc] initWithTitle:alertTitle message:alertMsg delegate:nil cancelButtonTitle:@"ok" otherButtonTitles:nil, nil];
    [alert show];
    TT_RELEASE_SAFELY(alert);
}


//压缩图片

- (UIImage*)imageByScalingAndCroppingForSize:(CGSize)targetSize sourceFromImage:(UIImage*) sourceImage

{    
    
    UIImage *newImage = nil;
    
    CGSize imageSize = sourceImage.size;
    
    CGFloat width = imageSize.width;
    
    CGFloat height = imageSize.height;
    
    CGFloat targetWidth = targetSize.width;
    
    CGFloat targetHeight = targetSize.height;
    
    CGFloat scaleFactor = 0.0;
    
    CGFloat scaledWidth = targetWidth;
    
    CGFloat scaledHeight = targetHeight;
    
    CGPoint thumbnailPoint = CGPointMake(0.0,0.0);
    
    if (CGSizeEqualToSize(imageSize, targetSize) == NO)
        
    {
        
        CGFloat widthFactor = targetWidth / width;
        
        CGFloat heightFactor = targetHeight / height;
        
        if (widthFactor > heightFactor)
            
            scaleFactor = widthFactor; // scale to fit height
        
        else
            
            scaleFactor = heightFactor; // scale to fit width
        
        scaledWidth= width * scaleFactor;
        
        scaledHeight = height * scaleFactor;
        
        // center the image
        
        if (widthFactor > heightFactor)
            
        {
            
            thumbnailPoint.y = (targetHeight - scaledHeight) * 0.5;
            
        }
        
        else if (widthFactor < heightFactor)
            
        {
            
            thumbnailPoint.x = (targetWidth - scaledWidth) * 0.5;
            
        }
        
    }
    
    UIGraphicsBeginImageContext(targetSize); // this will crop
    
    CGRect thumbnailRect = CGRectZero;
    
    thumbnailRect.origin = thumbnailPoint;
    
    thumbnailRect.size.width= scaledWidth;
    
    thumbnailRect.size.height = scaledHeight;
    
    [sourceImage drawInRect:thumbnailRect];
    
    newImage = UIGraphicsGetImageFromCurrentImageContext();
    
    if(newImage == nil)
        
        NSLog(@"could not scale image");
    
    //pop the context to get back to the default
    
    UIGraphicsEndImageContext();
    
    return newImage;
    
}



- (void)dealloc {
	[super dealloc];
}
@end
