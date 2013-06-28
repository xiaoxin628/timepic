//
//  TotoroTalkController.m
//  totorotalk
//
//  Created by lee will on 12-3-4.
//  Copyright (c) 2012年 __MyCompanyName__. All rights reserved.
//
#import <Three20/Three20.h>
#import "TotoroTalkController.h"
#import <AVFoundation/AVFoundation.h>

@implementation TotoroTalkController
///////////////////////////////////////////////////////////////////////////////////////////////////
// private

- (void)layout {
    TTFlowLayout* flowLayout = [[[TTFlowLayout alloc] init] autorelease];
    flowLayout.padding = 10;
    flowLayout.spacing = 14;
    CGSize size = [flowLayout layoutSubviews:self.view.subviews forView:self.view];
    
    UIScrollView* scrollView = (UIScrollView*)self.view;
//    scrollView.contentOffset = CGPointMake(10, 0);
    scrollView.contentInset = UIEdgeInsetsMake(0, 5, 0, 0);
    scrollView.contentSize = CGSizeMake(scrollView.width, size.height);
}


///////////////////////////////////////////////////////////////////////////////////////////////////
// NSObject

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil {
    if (self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil]) {
        _fontSize = 12;
        
        [TTStyleSheet setGlobalStyleSheet:[[[StyleSheet alloc] init] autorelease]];
    }
    return self;
}

- (void)dealloc {
//    [TTStyleSheet setGlobalStyleSheet:nil];
	[super dealloc];
}

///////////////////////////////////////////////////////////////////////////////////////////////////
// UIViewController

- (void)loadView {
    //设置导航栏背景色
    self.navigationBarTintColor = [UIColor blackColor];
    self.title = TTLocalizedString(@"totorotalk", @"Chinchilla Talk");
    self.navigationItem.leftBarButtonItem =
    [[[UIBarButtonItem alloc] initWithTitle:TTLocalizedString(@"Rate", @"Rate") 
                                      style:UIBarButtonItemStyleBordered
                                     target:@"http://itunes.apple.com/us/app/timepic-hui-shuo-hua-long/id516541985?ls=1&mt=8"
                                     action:@selector(openURLFromButton:)] autorelease];
    
    self.navigationItem.rightBarButtonItem =
    [[[UIBarButtonItem alloc] initWithTitle:TTLocalizedString(@"Popular", @"Popular") 
                                      style:UIBarButtonItemStyleBordered
                                     target:@"tt://photoThumb"
                                     action:@selector(openURLFromButton:)] autorelease];
    //tabbar 设置样式
    UIImage* tabimg = [UIImage imageNamed:@"tab1.png"];
    self.tabBarItem = [[[UITabBarItem alloc] initWithTitle:TTLocalizedString(@"talker", @"Translator") image:tabimg tag:0] autorelease];
    [self.tabBarItem setFinishedSelectedImage:tabimg withFinishedUnselectedImage:tabimg];

    
    //设置tabbarbutton 文本颜色
    [self.tabBarItem setTitleTextAttributes:[NSDictionary dictionaryWithObjectsAndKeys:[UIColor colorWithRed:0 green:0 blue:0 alpha:1.0],UITextAttributeTextColor, nil] forState:UIControlStateNormal];
    
    UIScrollView* scrollView = [[[UIScrollView alloc] initWithFrame:TTNavigationFrame()] autorelease];
	scrollView.autoresizesSubviews = YES;
	scrollView.autoresizingMask = UIViewAutoresizingFlexibleHeight;
    scrollView.showsHorizontalScrollIndicator = NO;
    scrollView.scrollEnabled = NO;
    //  背景图
    scrollView.backgroundColor = [UIColor colorWithPatternImage: [UIImage imageNamed: @"background.jpg"]];
    scrollView.canCancelContentTouches = NO;
    scrollView.delaysContentTouches = NO;
    self.view = scrollView;
    
    
    
//    头图
    TTImageView* headImg = [[[TTImageView alloc] initWithFrame:CGRectMake(0, 0, 320, 120)]
                              autorelease];
    //头图透明
    headImg.alpha = 0;
    
    [self.view addSubview:headImg];
    //按钮标题

    NSArray *buttons = [NSArray arrayWithObjects: 
                        [TTButton buttonWithStyle:@"embossedButton:" title:TTLocalizedString(@"bbsajiao", @"Flighty")],
                        [TTButton buttonWithStyle:@"embossedButton:" title:TTLocalizedString(@"bbshuixingle", @"Wake")],
                        [TTButton buttonWithStyle:@"embossedButton:" title:TTLocalizedString(@"bbyaoshuijiao", @"Sleep")],
                        [TTButton buttonWithStyle:@"embossedButton:" title:TTLocalizedString(@"chaojia", @"Quarrel")],
                        [TTButton buttonWithStyle:@"embossedButton:" title:TTLocalizedString(@"ddfaqing", @"Estrus")],
                        [TTButton buttonWithStyle:@"embossedButton:" title:TTLocalizedString(@"emengjinggao", @"Scared")],
                        [TTButton buttonWithStyle:@"embossedButton:" title:TTLocalizedString(@"jimo", @"Lonely")],
                        [TTButton buttonWithStyle:@"embossedButton:" title:TTLocalizedString(@"mamahuhuan", @"Eat")],
                        [TTButton buttonWithStyle:@"embossedButton:" title:TTLocalizedString(@"qiuou", @"Courtship")],
                        [TTButton buttonWithStyle:@"embossedButton:" title:TTLocalizedString(@"qiurao", @"Beg")],
                        [TTButton buttonWithStyle:@"embossedButton:" title:TTLocalizedString(@"shufu", @"Comfort")],
                        [TTButton buttonWithStyle:@"embossedButton:" title:TTLocalizedString(@"taoyan", @"Hate")],
                        [TTButton buttonWithStyle:@"embossedButton:" title:TTLocalizedString(@"teng", @"Hurt")],
                        [TTButton buttonWithStyle:@"embossedButton:" title:TTLocalizedString(@"xiangxizao", @"Bathe")],
                        [TTButton buttonWithStyle:@"embossedButton:" title:TTLocalizedString(@"xunzhaobanlv", @"Friend")],
                        [TTButton buttonWithStyle:@"embossedButton:" title:TTLocalizedString(@"youyaoqiu", @"Wanna")],
                        nil];
        //按钮设置
    for (TTButton* button in buttons) {
        button.tag = [buttons indexOfObject:button];
        [button setFont: [UIFont systemFontOfSize: _fontSize]];
        [button sizeToFit];
//        button.backgroundColor = [UIColor colorWithPatternImage: [UIImage imageNamed: @"miao.jpg"]];
        [button addTarget:self action:@selector(speak:) forControlEvents:UIControlEventTouchDown];
        [self.view addSubview: button];
    }
    [self layout];
}
//调用声音
-(void)speak:(TTButton *)button{
    NSArray *sounds = [NSArray arrayWithObjects:@"bbsajiao",
                        @"bbshuixingle",
                        @"bbyaoshuijiao",
                        @"chaojia",
                        @"ddfaqing",
                        @"emengjinggao",
                        @"jimo",
                        @"mamahuhuan",
                        @"qiuou",
                        @"qiurao",
                        @"shufu",
                        @"taoyan",
                        @"teng",
                        @"xiangxizao",
                        @"xunzhaobanlv",
                        @"youyaoqiu",
                      nil];
    if (!button.tag) {
        button.tag = 0;
    }
    [self playSound:[sounds objectAtIndex:button.tag]];
}

//播放声音
- (void)playSound:(NSString *) sound  {
    NSString *soundPath=[[NSBundle mainBundle] pathForResource:sound ofType:@"m4a"];   
    NSURL *soundUrl=[[NSURL alloc] initFileURLWithPath:soundPath];   
    player =[[AVAudioPlayer alloc] initWithContentsOfURL:soundUrl error:nil];   
    [player prepareToPlay];
    [player play];
    [soundUrl release];   
} 
@end
