//
//  ArticleController.m
//  totorotalk
//
//  Created by lee will on 12-3-11.
//  Copyright (c) 2012年 __MyCompanyName__. All rights reserved.
//

#import "ArticleTableController.h"


@implementation ArticleTableController
- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil {
    if (self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil]) {
        //设置导航栏背景色
        self.navigationBarTintColor = [UIColor blackColor];
        self.title = TTLocalizedString(@"totorowiki", @"totorowiki");
        self.variableHeightRows = YES;
        //tabbar 设置样式
        UIImage* tabimg = [UIImage imageNamed:@"tab2.png"];
        self.tabBarItem = [[[UITabBarItem alloc] initWithTitle:self.title image:tabimg tag:0] autorelease];
        [self.tabBarItem setFinishedSelectedImage:tabimg withFinishedUnselectedImage:tabimg];
        //设置tabbarbutton 文本颜色
        [self.tabBarItem setTitleTextAttributes:[NSDictionary dictionaryWithObjectsAndKeys:[UIColor colorWithRed:0 green:0 blue:0 alpha:1.0],UITextAttributeTextColor, nil] forState:UIControlStateNormal];
    }
    return self;
}

/////////////////////////////////////////////////////////////////////////////////////////////////
- (void)createModel {
	self.dataSource = [[[ArticleDataSource alloc]
						initWithSearchQuery:@"page" andQueryValue:@"1"] autorelease];
}
///////////////////////////////////////////////////////////////////////////////////////////////////
- (id<UITableViewDelegate>)createDelegate {
	return [[[TTTableViewDragRefreshDelegate alloc] initWithController:self] autorelease];
}
@end
