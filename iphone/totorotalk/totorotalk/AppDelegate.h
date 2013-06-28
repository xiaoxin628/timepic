//
//  AppDelegate.h
//  totorotalk
//
//  Created by WillLee on 12-2-26.
//  Copyright (c) 2012年 __MyCompanyName__. All rights reserved.
//

#import <Three20/Three20.h>

@interface AppDelegate : NSObject <UIApplicationDelegate>{
    UIWindow*               _window;
    UINavigationController* _navigationController;
}


@property (nonatomic, retain) IBOutlet UIWindow*                window;
@property (nonatomic, retain) IBOutlet UINavigationController*  navigationController;

@end

