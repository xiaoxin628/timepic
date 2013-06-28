#import <Three20/Three20.h>

@interface PhotoThumbsAllController : TTThumbsViewController {
}
- (NSString*)URLForPhoto:(id<TTPhoto>)photo;
- (void)updateTableLayout;
@end
