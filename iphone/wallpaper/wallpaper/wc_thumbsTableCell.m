//
//  wc_thumbsTableCell.m
//  wallpaper
//
//  Created by Lee Will on 12-1-29.
//  Copyright (c) 2012年 __MyCompanyName__. All rights reserved.
//

#import "wc_thumbsTableCell.h"

static const CGFloat kSpacing = 4.0f;
static const CGFloat kDefaultThumbSize = 150.0f;

@implementation wc_thumbsTableCell

///////////////////////////////////////////////////////////////////////////////////////////////////
- (id)initWithStyle:(UITableViewCellStyle)style reuseIdentifier:(NSString*)identifier {
	self = [super initWithStyle:style reuseIdentifier:identifier];
    if (self) {
        _thumbViews = [[NSMutableArray alloc] init];
        _thumbSize = kDefaultThumbSize;
        _thumbOrigin = CGPointMake(kSpacing, 0);
        
        self.accessoryType = UITableViewCellAccessoryNone;
        self.selectionStyle = UITableViewCellSelectionStyleNone;
    }
    
    return self;
}

///////////////////////////////////////////////////////////////////////////////////////////////////
- (void)setThumbSize:(CGFloat)thumbSize {
    _thumbSize = kDefaultThumbSize;
    [self setNeedsLayout];
}

///////////////////////////////////////////////////////////////////////////////////////////////////
- (void)suspendLoading:(BOOL)suspended {
    for (TTThumbView* thumbView in _thumbViews) {
        [thumbView suspendLoadingImages:suspended];
    }
}
@end
