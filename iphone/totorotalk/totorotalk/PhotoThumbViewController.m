//
//  PhotoThumbViewController.m
//  totorotalk
//
//  Created by lee will on 12-4-4.
//  Copyright (c) 2012年 __MyCompanyName__. All rights reserved.
//

#import "PhotoThumbViewController.h"
static        NSString* api  = @"http://www.timepic.net/totorotalk/api/photo/photolist/%@/%@/key/fa299ad0fc857f005b03fb5670d1e2ca";
@implementation PhotoThumbViewController


- (void)viewDidLoad {
    [self getHotPhoto];
}


- (void)getHotPhoto
{
    NSString* url = [NSString stringWithFormat:api, @"page", @"1"];
    TTURLRequest* request = [TTURLRequest
                             requestWithURL: url
                             delegate: self];
    request.cachePolicy = TTURLRequestCachePolicyNone;
    request.cacheExpirationAge = 3600*24*14;
    request.httpMethod = @"GET";
    TTURLJSONResponse* response = [[TTURLJSONResponse alloc] init];
    request.response = response;
    TT_RELEASE_SAFELY(response);
    [request send];
}

//
///////////////////////////////////////////////////////////////////////////////////////////////////
- (void)requestDidFinishLoad:(TTURLRequest*)request {
    [[TTURLRequestQueue mainQueue] setMaxContentLength:0];
	TTURLJSONResponse* response = request.response;
	TTDASSERT([response.rootObject isKindOfClass:[NSDictionary class]]);
	
	NSDictionary* datas = response.rootObject;
	TTDASSERT([[datas objectForKey:@"datas"] isKindOfClass:[NSArray class]]);
      NSArray* entries = [datas objectForKey:@"datas"];
      NSMutableArray * photos = [[NSMutableArray alloc] init];
    for (NSDictionary* entry in entries) {
        MockPhoto *photo = [[[MockPhoto alloc] 
                            initWithURL:[entry objectForKey:@"image"]
                            smallURL:[entry objectForKey:@"thumb"]
                            size:CGSizeMake(320, 480)] autorelease];
        [photos addObject:photo];
        TT_RELEASE_SAFELY(photo);
    }
    NSLog(@"request");
    self.photoSource = [[MockPhotoSource alloc]
                        initWithType:MockPhotoSourceNormal
                        //initWithType:MockPhotoSourceDelayed
                        // initWithType:MockPhotoSourceLoadError
                        // initWithType:MockPhotoSourceDelayed|MockPhotoSourceLoadError
                        title:@"Photos"
                        photos:photos
                        photos2:nil
                        ];
}
/////////////////////////////////////////////////////////////////////////////////////////////////


@end
