#import "AppDelegate.h"
#import "PhotoThumbsController.h"
#import "PhotoViewAllController.h"
@implementation AppDelegate

///////////////////////////////////////////////////////////////////////////////////////////////////
// UIApplicationDelegate

- (void)applicationDidFinishLaunching:(UIApplication*)application {
    TTNavigator* navigator = [TTNavigator navigator];
    navigator.supportsShakeToReload = NO;
    navigator.persistenceMode = TTNavigatorPersistenceModeAll;
    
    TTURLMap* map = navigator.URLMap;
    [map from:@"*" toViewController:[TTWebController class]];
    
    
    [map                    from: @"tt://photoThumbs"
          toSharedViewController: [PhotoThumbsAllController class]];
    
    [map            from: @"tt://photoViewAll"
                  parent: @"tt://photoThumbs"
        toViewController: [PhotoViewAllController class]
                selector: nil
              transition: 0];
    if (![navigator restoreViewControllers]) {
        [navigator openURLAction:[TTURLAction actionWithURLPath:@"tt://photoThumbs"]];
    }
}

- (BOOL)application:(UIApplication*)application handleOpenURL:(NSURL*)URL {
    [[TTNavigator navigator] openURLAction:[TTURLAction actionWithURLPath:URL.absoluteString]];
    return YES;
}

@end
