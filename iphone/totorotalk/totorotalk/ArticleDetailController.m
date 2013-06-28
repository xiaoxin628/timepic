//
//  ArticleDetailController.m
//  totorotalk
//
//  Created by lee will on 12-3-11.
//  Copyright (c) 2012年 __MyCompanyName__. All rights reserved.
//

#import "ArticleDetailController.h"
#import <extThree20JSON/extThree20JSON.h>
#import "Article.h"
static        NSString* api  = @"http://www.timepic.net/totorotalk/api/Article/getinfo/%@/%@";
//static        NSString* api  = @"http://test.timepic.net/index.php?r=totorotalk/api/Article/getinfo/%@/%@";


@implementation ArticleDetailController


@synthesize MyId = _MyId;
@synthesize article;
@synthesize TitleLabel;
@synthesize ContentLabel;
@synthesize DetailScrollView;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil Aid:(NSString *)Aid
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    //设置导航栏背景色
    self.navigationBarTintColor = [UIColor blackColor];
    if (self) {
		_MyId = Aid;
		[self requestAction];
    }
    return self;
}

- (void)didReceiveMemoryWarning
{
    // Releases the view if it doesn't have a superview.
    [super didReceiveMemoryWarning];
    
    // Release any cached data, images, etc that aren't in use.
}

#pragma mark - View lifecycle

- (void)viewDidLoad
{
    [super viewDidLoad];
    // Do any additional setup after loading the view from its nib.
}

- (void)viewDidUnload
{
    [super viewDidUnload];
    // Release any retained subviews of the main view.
    // e.g. self.myOutlet = nil;
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    // Return YES for supported orientations
    return (interfaceOrientation == UIInterfaceOrientationPortrait);
}

#pragma mark -
#pragma mark ScrollView Methods
- (UIView *)viewForZoomingInScrollView:(UIScrollView *)scrollView
{
	return DetailScrollView;
}

#pragma mark -
#pragma mark Request Methods
///////////////////////////////////////////////////////////////////////////////////////////////////
- (void) requestAction {
	NSString* url = [NSString stringWithFormat:api, @"id", _MyId];
    
	TTURLRequest* request = [TTURLRequest requestWithURL: url
												delegate: self];
	
	// TTURLImageResponse is just one of a set of response types you can use.
	// Also available are TTURLDataResponse and TTURLXMLResponse.
	request.cachePolicy = 3600*24;
    //	request.cacheExpirationAge = TT_CACHE_EXPIRATION_AGE_NEVER;
	
	TTURLJSONResponse* response = [[TTURLJSONResponse alloc] init];
	request.response = response;
	TT_RELEASE_SAFELY(response);
	
	[request send];
}


///////////////////////////////////////////////////////////////////////////////////////////////////
- (void) clearCacheAction {
	[[TTURLCache sharedCache] removeAll:YES];
}


///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
#pragma mark -
#pragma mark TTURLRequestDelegate


///////////////////////////////////////////////////////////////////////////////////////////////////
- (void)requestDidStartLoad:(TTURLRequest*)request {
	NSLog(@"loading...");
}


///////////////////////////////////////////////////////////////////////////////////////////////////
- (void)requestDidFinishLoad:(TTURLRequest*)request {
	TTURLJSONResponse* response = request.response;
	TTDASSERT([response.rootObject isKindOfClass:[NSDictionary class]]);
	
	NSDictionary* datas = response.rootObject;
	TTDASSERT([[datas objectForKey:@"datas"] isKindOfClass:[NSArray class]]);
	
	NSArray* entries = [datas objectForKey:@"datas"];
	article = [[Article alloc] init];
	article.articleId = [[entries objectAtIndex:0] objectForKey: @"id"];
	article.articleTitle = [[entries objectAtIndex:0] objectForKey: @"title"];
	article.articleContent = [[entries objectAtIndex:0] objectForKey: @"content"];
	[TitleLabel setText:article.articleTitle];

	ContentLabel.text = article.articleContent;
	//让contentlabel自适应内容大小
	CGSize labelsize = [ContentLabel sizeThatFits:CGSizeMake(280,0)];
	CGRect fitRct = ContentLabel.frame;
	fitRct.size = labelsize;
	ContentLabel.frame = fitRct;
	//重置 jokeDetailScrollView大小 为了一下可以滑动到底部 加高度100
	CGFloat scrollHeight = TitleLabel.frame.size.height + ContentLabel.frame.size.height;
	[DetailScrollView setContentSize:CGSizeMake(320.0, scrollHeight + 100)];
	[UIView commitAnimations];
}


///////////////////////////////////////////////////////////////////////////////////////////////////
- (void)request:(TTURLRequest*)request didFailLoadWithError:(NSError*)error {
	NSLog(@"fail");
}

- (void)dealloc {
    TT_RELEASE_SAFELY(article);
	[super dealloc];
}




@end
