<?php

namespace App\Http\Controllers;

use Log;
use DateTime;
use App\Models\TikTok;
use App\Models\TikTokDaily;
use App\Models\Trend;
use Illuminate\Http\Request;

class RestApiController extends Controller
{
    public function users() {
        $tiktokModel = new TikTok();
        $users = $tiktokModel->getUsers();

        return response()->json($users);
    }

    public function saveUser(Request $request) {
        try {
            $params = $request->all();
            $id = $params['id'];
            $avatar = $params['avatar'];
            $uniqueId = $params['uniqueId'];
            $nickname = $params['nickname'];
            $follercount = $params['follercount'];
            $followingcount = $params['followingcount'];
            $diggcount = $params['diggcount'];
            $heart = $params['heart'];
            $videocount = $params['videocount'];
            $signature = $params['signature'];

            $userInExist = TikTok::where('uniqueId', $uniqueId)->first();
            if ($userInExist != null) {
                $follercountInc = $follercount - $userInExist->follercount;
                $followingcountInc = $followingcount - $userInExist->followingcount;
                $diggcountInc = $diggcount - $userInExist->diggcount;
                $heartInc = $heart - $userInExist->heart;
                $videocountInc = $videocount - $userInExist->videocount;

                $diggcountInc = $diggcountInc >= 0? $diggcountInc : 0;
                $heartInc = $heartInc >= 0? $heartInc : 0;
                $videocountInc = $videocountInc >= 0? $videocountInc : 0;
    
                $userInExist->avatar = $avatar;
                $userInExist->nickname = $nickname;
                $userInExist->follercount = $follercount;
                $userInExist->followingcount = $followingcount;
                $userInExist->diggcount = $diggcount;
                $userInExist->heart = $heart;
                $userInExist->videocount = $videocount;
                $userInExist->signature = $signature;
                $userInExist->save();
    
                $userInDaily = new TikTokDaily();
                $userInDaily->user_id = $id;
                $userInDaily->follercount_grow = $follercountInc;
                $userInDaily->followingcount_grow = $followingcountInc;
                $userInDaily->diggcount_grow = $diggcountInc;
                $userInDaily->heart_grow = $heartInc;
                $userInDaily->videocount_grow = $videocountInc;
                $userInDaily->save();
            }

            return response()->json([
                'success'   => 'success'
            ], 200);
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            return response()->json([
                'error'   => 'invalid'
            ], 401);
        }
    }

    public function saveTrending(Request $request) {
        $params = $request->all();
        $params = json_decode($params['data']);

        foreach($params as $index => $item) {
            $trend = Trend::create();
            $trend->title = $item->music->title;
            $trend->long_id = $item->music->id;
            $trend->video_cover = $item->music->coverThumb;
            $trend->comment_count = $item->stats->commentCount;
            $trend->play_count = $item->stats->playCount;
            $trend->share_count = $item->stats->shareCount;
            // $trend->create_time = gmdate('Y-m-d', strtotime($item->createTime));
            $trend->create_time = (new DateTime("@$item->createTime"))->format('Y-m-d');
            $trend->tiktoker = $item->author->uniqueId;
            $trend->tiktok_avatar = $item->author->avatarThumb;
            $trend->save();
        }

        return response()->json([
            'success'   => 'success'
        ], 200);
    }
}
