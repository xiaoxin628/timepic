#import "TabBarController.h"

@implementation TabBarController

///////////////////////////////////////////////////////////////////////////////////////////////////
// UIViewController

- (void)viewDidLoad {
    self.tabBar.tintColor = [UIColor clearColor];
    self.tabBar.backgroundColor = [UIColor clearColor];
    self.tabBar.backgroundImage = [UIImage imageNamed:@"banner.png"];
    
  [self setTabURLs:[NSArray arrayWithObjects:@"tt://totoroTalk",
                                             @"tt://camera/upload",
                                             @"tt://articleTable",

                                             nil]];
}

@end
