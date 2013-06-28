#import "PhotoViewAllController.h"
#import "MockPhotoSource.h"

@implementation PhotoViewAllController
//重载 photoviewcontroller 换右边的按钮
///////////////////////////////////////////////////////////////////////////////////////////////////
- (void)updateChrome {
    if (_photoSource.numberOfPhotos < 2) {
        self.title = _photoSource.title;
        
    } else {
        self.title = [NSString stringWithFormat:
                      TTLocalizedString(@"%d of %d", @"Current page in photo browser (1 of 10)"),
                      _centerPhotoIndex+1, _photoSource.numberOfPhotos];
    }
    
    if (![self.ttPreviousViewController isKindOfClass:[TTThumbsViewController class]]) {
        if (_photoSource.numberOfPhotos > 1) {
            self.navigationItem.rightBarButtonItem =
            [[[UIBarButtonItem alloc] initWithTitle:TTLocalizedString(@"See All",
                                                                      @"See all photo thumbnails")
                                              style:UIBarButtonItemStyleBordered
                                             target:self
                                             action:@selector(showThumbnails)]
             autorelease];
            
        } else {
            self.navigationItem.rightBarButtonItem = nil;
        }
        
    } else {
        self.navigationItem.rightBarButtonItem =
        [[[UIBarButtonItem alloc] initWithTitle:TTLocalizedString(@"Download", @"download img")
                                                style:UIBarButtonItemStyleBordered
                                                target:self
                                         action:@selector(SaveImageToPhotoAlbum:)]
         autorelease];
    }
    
    UIBarButtonItem* playButton = [_toolbar itemWithTag:1];
    playButton.enabled = _photoSource.numberOfPhotos > 1;
    _previousButton.enabled = _centerPhotoIndex > 0;
    _nextButton.enabled = _centerPhotoIndex >= 0 && _centerPhotoIndex < _photoSource.numberOfPhotos-1;
}



-(IBAction) SaveImageToPhotoAlbum:(id)sender{
    NSString *urlPath = [ self.centerPhoto URLForVersion:TTPhotoVersionLarge];
    //去除 bundle://
    NSString *picname = [urlPath stringByReplacingOccurrencesOfString:@"bundle://" withString:@""];
    UIImage *img = [UIImage imageNamed:picname];
    // 保存图片到相册中
//    NSLog(@"%@", urlPath);
    UIImageWriteToSavedPhotosAlbum(img, self, @selector(image:didFinishSavingWithError:contextInfo:), nil);
    TT_RELEASE_SAFELY(urlPath);
    TT_RELEASE_SAFELY(img);
}  

- (void)image:(UIImage *)image didFinishSavingWithError:(NSError *)error contextInfo:(void *)contextInfo{
    NSString *message;
    NSString *title;
    // Was there an error?
    if (error != NULL)
    {
        // Show error message...
        title = TTLocalizedString(@"Failed to save", @"Failed to save");
        message = [error description];
    }else{
          // No errors
        // Show message image successfully saved
        title = TTLocalizedString(@"Save success", @"Save success");
        message = TTLocalizedString(@"Picture has been saved to Album", @"Picture has been saved to Album");

    }
    UIAlertView *alert = [[UIAlertView alloc] initWithTitle:title message:message delegate:nil cancelButtonTitle:@"OK" otherButtonTitles:nil, nil];
    [alert show];
    TT_RELEASE_SAFELY(alert);
}

@end
