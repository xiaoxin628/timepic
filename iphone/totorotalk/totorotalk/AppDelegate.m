#import "AppDelegate.h"
#import "TabBarController.h"
#import "TotoroTalkController.h"
#import "ArticleTableController.h"
#import "CameraController.h"
#import "PhotoThumbViewController.h"
#import "HotPhoto.h"
@implementation AppDelegate

@synthesize window                = _window;
@synthesize navigationController  = _navigationController;

///////////////////////////////////////////////////////////////////////////////////////////////////
// UIApplicationDelegate

- (void)applicationDidFinishLaunching:(UIApplication*)application {
    TTNavigator* navigator = [TTNavigator navigator];
    navigator.supportsShakeToReload = NO;
    navigator.persistenceMode = TTNavigatorPersistenceModeAll;
    
    
//    navigator.window = [[[UIWindow alloc] initWithFrame:TTScreenBounds()] autorelease];
    navigator.window = self.window;
    TTURLMap* map = navigator.URLMap;
    [map from:@"*" toViewController:[TTWebController class]];
    
    [map from:@"tt://tabBar" toSharedViewController:[TabBarController class]];
    
    [map from:@"tt://articleTable" toSharedViewController:[ArticleTableController class]];
    
    [map from:@"tt://totoroTalk" toSharedViewController: [TotoroTalkController class]];
    
    [map from:@"tt://camera/(uploadPhoto:)" toSharedViewController: [CameraController class]];
    
    [map from:@"tt://photoThumb" toSharedViewController: [PhotoThumbViewController class]];
    
    //加载nib文件
	[map from:@"tt://nib/(loadFromNib:)/(withClass:)/(Aid:)" toViewController:self];	
    [map from:@"tt://nib/(loadFromNib:)" toSharedViewController:self];
    [map from:@"tt://nib/(loadFromNib:)/(withClass:)" toSharedViewController:self];
    
    if (![navigator restoreViewControllers]) {
        [navigator openURLAction:[TTURLAction actionWithURLPath:@"tt://tabBar"]];
    }
}



///////////////////////////////////////////////////////////////////////////////////////////////////
- (void)dealloc {
    TT_RELEASE_SAFELY(_navigationController);
    TT_RELEASE_SAFELY(_window);
    
    [super dealloc];
}

/////////////////////////////////////////////////////////////////////////////////////////////////
/**
 *加载冷笑话详细信息页面
 */
- (UIViewController*)loadFromNib:(NSString *)nibName withClass:className Aid:(NSString *)Aid{
	UIViewController* newController = [[NSClassFromString(className) alloc]
									   initWithNibName:nibName bundle:nil Aid:Aid];
	[newController autorelease];
	
	return newController;
}

///////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * Loads the given viewcontroller from the nib
 */
- (UIViewController*)loadFromNib:(NSString *)nibName withClass:className {
    UIViewController* newController = [[NSClassFromString(className) alloc]
                                       initWithNibName:nibName bundle:nil];
    [newController autorelease];
    
    return newController;
}


///////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * Loads the given viewcontroller from the the nib with the same name as the
 * class
 */
- (UIViewController*)loadFromNib:(NSString*)className {
    return [self loadFromNib:className withClass:className];
}


///////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * Loads the given viewcontroller by name
 */
- (UIViewController *)loadFromVC:(NSString *)className {
    UIViewController * newController = [[ NSClassFromString(className) alloc] init];
    [newController autorelease];
    
    return newController;
}



- (BOOL)application:(UIApplication*)application handleOpenURL:(NSURL*)URL {
    [[TTNavigator navigator] openURLAction:[TTURLAction actionWithURLPath:URL.absoluteString]];
    return YES;
}
@end
