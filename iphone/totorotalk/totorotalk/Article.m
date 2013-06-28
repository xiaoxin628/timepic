//
//  Article.m
//  totorotalk
//
//  Created by lee will on 12-3-11.
//  Copyright (c) 2012年 __MyCompanyName__. All rights reserved.
//

#import "Article.h"

@implementation Article

@synthesize articleId   =_articleId;
@synthesize articleTitle   = _articleTitle;
@synthesize articleContent      = _articleContent;
@synthesize articleImage    = _articleImage;
@synthesize articleThumbImg = _articleThumbImg;
@synthesize dateline    = _dateline;


- (void) dealloc {
	TT_RELEASE_SAFELY(_articleId);
	TT_RELEASE_SAFELY(_articleTitle);
	TT_RELEASE_SAFELY(_articleContent);
	TT_RELEASE_SAFELY(_articleImage);
	TT_RELEASE_SAFELY(_articleThumbImg);
	TT_RELEASE_SAFELY(_dateline);
	[super dealloc];
}
@end
