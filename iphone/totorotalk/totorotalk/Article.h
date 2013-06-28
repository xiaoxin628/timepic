//
//  Article.h
//  totorotalk
//
//  Created by lee will on 12-3-11.
//  Copyright (c) 2012年 __MyCompanyName__. All rights reserved.
//

//龙猫文章类
@interface Article : NSObject {
	//ID
	NSNumber  *_articleId;
	//标题
	NSString	*_articleTitle;
	//内容
	NSString	*_articleContent;
	//图片地址
	NSString	*_articleImage;
	//缩略图地址
	NSString	*_articleThumbImg;
	//创建时间 格式 2010-4-10 20:46:10
	NSDate*   _dateline;
}

@property (nonatomic, retain) NSNumber *articleId;
@property (nonatomic, retain) NSString *articleTitle;
@property (nonatomic, retain) NSString *articleContent;
@property (nonatomic, retain) NSString *articleImage;
@property (nonatomic, retain) NSString *articleThumbImg;
@property (nonatomic, retain) NSDate   *dateline;

@end

