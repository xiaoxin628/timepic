//
//  ArticleDataSource.h
//  totorotalk
//
//  Created by lee will on 12-3-11.
//  Copyright (c) 2012年 __MyCompanyName__. All rights reserved.
//
#import <Three20/Three20.h>
#import "ArticleTableController.h"
#import "ArticleGetDataModel.h"
#import "Article.h"

@interface ArticleDataSource : TTListDataSource{
    	ArticleGetDataModel * _searchDataModel;
}

- (id)initWithSearchQuery:(NSString*)searchQuery andQueryValue:(NSString *)QueryValue;
@end
