//
//  wc_photoDataSource.m
//  wallpaper
//
//  Created by Lee Will on 12-1-29.
//  Copyright (c) 2012年 __MyCompanyName__. All rights reserved.
//

#import "wc_photoDataSource.h"
static CGFloat kThumbSize = 150.0f;
static CGFloat kThumbSpacing = 4.0f;
@implementation wc_photoDataSource

///////////////////////////////////////////////////////////////////////////////////////////////////
- (NSInteger)columnCountForView:(UIView *)view {
    CGFloat width = view.bounds.size.width;
    return floorf((width - kThumbSpacing) / (kThumbSize+kThumbSpacing) + 0.1);
}

///////////////////////////////////////////////////////////////////////////////////////////////////
- (void)        tableView: (UITableView*)tableView
                     cell: (UITableViewCell*)cell
    willAppearAtIndexPath: (NSIndexPath*)indexPath {
    if ([cell isKindOfClass:[TTThumbsTableViewCell class]]) {
        TTThumbsTableViewCell* thumbsCell = (TTThumbsTableViewCell*)cell;
        thumbsCell.thumbSize = kThumbSize;
        thumbsCell.delegate = _delegate;
        thumbsCell.columnCount = [self columnCountForView:tableView];
    }
}
@end
