//
//  ArticleDetailController.h
//  totorotalk
//
//  Created by lee will on 12-3-11.
//  Copyright (c) 2012年 __MyCompanyName__. All rights reserved.
//

#import <Three20/Three20.h>
#import "Article.h"
@class Article;
@interface ArticleDetailController : TTViewController {
}

@property  (nonatomic, retain) NSString *MyId;
@property (nonatomic, retain) Article *article;

@property (nonatomic, retain) IBOutlet UILabel *TitleLabel;
@property (nonatomic, retain) IBOutlet UILabel *ContentLabel;
@property (nonatomic, retain) IBOutlet UIScrollView *DetailScrollView;

- (id)initWithNibName:(NSString*)nibName bundle:(NSBundle*)bundle Aid:(NSString *)Aid;
- (void) requestAction;
@end
