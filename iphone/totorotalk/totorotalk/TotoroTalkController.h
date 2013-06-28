//
//  TotoroTalkController.h
//  totorotalk
//
//  Created by lee will on 12-3-4.
//  Copyright (c) 2012年 __MyCompanyName__. All rights reserved.
//

#import <Three20/Three20.h>
#import <AVFoundation/AVFoundation.h>
#import "StyleSheet.h"
#import "CameraController.h"
#import "PhotoThumbViewController.h"
@interface TotoroTalkController : TTViewController{
    CGFloat _fontSize;
    AVAudioPlayer *player;
}

-(void)speak:(NSString *)word;
- (void)playSound:(NSString *) sound;
@end
