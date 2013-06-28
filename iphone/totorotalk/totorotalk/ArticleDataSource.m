//
//  ArticleDataSource.m
//  totorotalk
//
//  Created by lee will on 12-3-11.
//  Copyright (c) 2012年 __MyCompanyName__. All rights reserved.
//

#import "ArticleDataSource.h"

@implementation ArticleDataSource



///////////////////////////////////////////////////////////////////////////////////////////////////
- (id)initWithSearchQuery:(NSString*)searchQuery andQueryValue:(NSString *)QueryValue{
	if (self = [super init]) {
		_searchDataModel = [[ArticleGetDataModel alloc] initWithSearchQuery:searchQuery andQueryValue:QueryValue];
	}
	
	return self;
}


///////////////////////////////////////////////////////////////////////////////////////////////////
- (void)dealloc {
	TT_RELEASE_SAFELY(_searchDataModel);
	
	[super dealloc];
}


///////////////////////////////////////////////////////////////////////////////////////////////////
- (id<TTModel>)model {
	return _searchDataModel;
}


///////////////////////////////////////////////////////////////////////////////////////////////////
- (void)tableViewDidLoadModel:(UITableView*)tableView {
	NSMutableArray* items = [[NSMutableArray alloc] init];
	//循环制造Article 数据源
	for (Article* article in _searchDataModel.datas) {
		//TTDPRINT(@"Response text: %@", response.text);
		//用自定义类JokesTableItem 来接受数据
        [items addObject:[TTTableSubtitleItem itemWithText:article.articleTitle
                                                  subtitle:article.articleContent
                                                      URL:[NSString stringWithFormat:@"tt://nib/ArticleDetailController/ArticleDetailController/%d", [article.articleId intValue]]
                          ]
         ];
		//检测title不为空
		TTDASSERT(nil != article.articleTitle);
	}
	//释放转换时间对象
//	if (!_searchDataModel.finished) {
//		[items addObject:[TTTableMoreButton itemWithText:@"more…"]];
//	}
	
	self.items = items;
	TT_RELEASE_SAFELY(items);
}

-(Class)tableView:(UITableView *)tableView cellClassForObject:(id)object{
	return [super tableView:tableView
	     cellClassForObject:object];
}
///////////////////////////////////////////////////////////////////////////////////////////////////
- (NSString*)titleForLoading:(BOOL)reloading {
	if (reloading) {
		return NSLocalizedString(@"Updating ...", @"updating text");
	} else {
		return NSLocalizedString(@"Loading...", @"loading text");
	}
}


///////////////////////////////////////////////////////////////////////////////////////////////////
- (NSString*)titleForEmpty {
	return NSLocalizedString(@"Not found.", @"no results");
}


///////////////////////////////////////////////////////////////////////////////////////////////////
- (NSString*)subtitleForError:(NSError*)error {
	return NSLocalizedString(@"Sorry, there was an error loading the stream.", @"");
}



@end
