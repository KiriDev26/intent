<?php


namespace App\Helpers;


use App\Comment;
use App\Like;
use App\Post;

class LikeHelper
{
    protected const TYPE_COMMENT = 'comment';

    protected const TYPE_POST = 'post';

    protected $type;

    /**
     * LikeHelper constructor.
     * @param $type
     */
    public function __construct($type)
    {
        if ($type === self::TYPE_COMMENT) {
            $this->type = Comment::class;
        } elseif ($type === self::TYPE_POST) {
           $this->type = Post::class;
        }
    }

    /**
     * @param $modelId
     * @return bool
     */
    public function attach($modelId)
    {
        if (empty($modelId) || empty($this->type)) {
            return false;
        }

        if ($this->check($modelId)) {
            return false;
        }

        return Like::create([
            'entity' => $this->type,
            'attach_id' => $modelId,
            'user_id' => auth()->user()->id
        ]);
    }

    /**
     * @param $modelId
     * @return bool
     */
    public static function unattached($id)
    {
        if (empty($id)) {

            return false;
        }

        $like = Like::where('id', $id)
            ->where('user_id', auth()->user()->id)
            ->first();

        if ($like) {
            $like->delete();

            return true;
        }

        return false;
    }

    /**
     * @param $modelId
     * @return bool
     */
    private function check($modelId)
    {
        $condition = Like::where('entity', $this->type)
            ->where('attach_id', $modelId)
            ->where('user_id', auth()->user()->id)
            ->count();

        return $condition > 0;
    }
}
