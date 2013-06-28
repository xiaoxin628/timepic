#import "PhotoThumbsController.h"
#import "PhotoViewAllController.h"
#import "MockPhotoSource.h"
#import "wc_photoDataSource.h"
#import "wc_thumbsTableCell.h"

@implementation PhotoThumbsAllController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil {
    if (self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil]) {
        self.navigationItem.backBarButtonItem =
        [[[UIBarButtonItem alloc] initWithTitle:TTLocalizedString(@"view all", @"view all pic") style:UIBarButtonItemStyleBordered
                                         target:nil action:nil] autorelease];
    }
    return self;
}
///////////////////////////////////////////////////////////////////////////////////////////////////
- (void)loadView {
    [super loadView];
    //图片列表每行高度
    self.tableView.rowHeight = 155.0f;
    //图片间距
    self.tableView.autoresizingMask = UIViewAutoresizingFlexibleWidth;
    //图片列表视图背景颜色
    self.tableView.backgroundColor = [UIColor lightGrayColor];
    self.tableView.separatorStyle = UITableViewCellSeparatorStyleNone;
    [self updateTableLayout];
}

///////////////////////////////////////////////////////////////////////////////////////////////////
- (void)updateTableLayout {
    self.tableView.contentInset = UIEdgeInsetsMake(TTBarsHeight()+4, 0, 0, 0);
    self.tableView.scrollIndicatorInsets = UIEdgeInsetsMake(TTBarsHeight(), 0, 0, 0);
}

- (void)viewDidLoad {
    [super viewDidLoad];
    //照片数据处理
    NSMutableArray * myPhoto = [[NSMutableArray alloc] init];
    for (int counter =72; counter>=1; counter = counter - 1) {
        MockPhoto *photo = [[MockPhoto new] 
                            initWithURL:[@"bundle://wc-" stringByAppendingFormat:@"%d.jpg",counter]
                            smallURL:[@"bundle://wc-thumb-" stringByAppendingFormat:@"%d.jpg",counter]
                            size:CGSizeMake(640, 960)];
        [myPhoto addObject: photo];
        [photo release];
    }
    
    self.photoSource = [[MockPhotoSource alloc] 
                        
                        initWithType:MockPhotoSourceNormal
                        title:TTLocalizedString(@"wallpaper", @"the menu name")
                        photos:myPhoto
                        photos2:nil
                        ];
    TT_RELEASE_SAFELY(myPhoto);
 }



///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
#pragma mark -
#pragma mark TTThumbsTableViewCellDelegate

//重载方法 然后更改photoview的类 不然没法增加按钮
///////////////////////////////////////////////////////////////////////////////////////////////////
- (void)thumbsTableViewCell:(TTThumbsTableViewCell*)cell didSelectPhoto:(id<TTPhoto>)photo {
    [_delegate thumbsViewController:self didSelectPhoto:photo];
    
    BOOL shouldNavigate = YES;
    if ([_delegate respondsToSelector:@selector(thumbsViewController:shouldNavigateToPhoto:)]) {
        shouldNavigate = [_delegate thumbsViewController:self shouldNavigateToPhoto:photo];
    }
    
    if (shouldNavigate) {
        NSString* URL = [self URLForPhoto:photo];
        if (URL) {
            TTOpenURLFromView(URL, self.view);
            
        } else {
            TTPhotoViewController* controller = [self createPhotoViewController];
            controller.centerPhoto = photo;
            [self.navigationController pushViewController:controller animated:YES];
        }
    }
}

- (TTPhotoViewController*)createPhotoViewController {
    return [[[PhotoViewAllController alloc] init] autorelease];
}

///////////////////////////////////////////////////////////////////////////////////////////////////
- (NSString*)URLForPhoto:(id<TTPhoto>)photo {
    if ([photo respondsToSelector:@selector(URLValueWithName:)]) {
        return [photo URLValueWithName:@"TTPhotoViewController"];
        
    } else {
        return nil;
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////
- (void)suspendLoadingThumbnails:(BOOL)suspended {
    if (_photoSource.maxPhotoIndex >= 0) {
        NSArray* cells = _tableView.visibleCells;
        for (int i = 0; i < cells.count; ++i) {
            TTThumbsTableViewCell* cell = [cells objectAtIndex:i];
            if ([cell isKindOfClass:[TTThumbsTableViewCell class]]) {
                [cell suspendLoading:suspended];
            }
        }
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////
- (id<TTTableViewDataSource>)createDataSource {
    return [[[wc_photoDataSource alloc] initWithPhotoSource:_photoSource delegate:self] autorelease];
}

#ifdef _FOR_DEBUG_  
-(BOOL) respondsToSelector:(SEL)aSelector {  
    printf("SELECTOR: %s\n", [NSStringFromSelector(aSelector) UTF8String]);  
    return [super respondsToSelector:aSelector];  
}  
#endif


@end
