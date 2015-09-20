<?php namespace Orchestra\Story\Policies;

use Orchestra\Authorization\Policy;

class ContentPolicy extends Policy
{
    /**
     * Authorization driver name.
     *
     * @var string
     */
    protected $name = 'orchestra/story';

    public function create(Authenticatable $user, Content $content)
    {
        $type = $content->type;

        return $this->can("create {$type}") || $this->can("manage {$type}");
    }

    public function update(Authenticatable $user, Content $content)
    {
        $type  = $content->type;
        $owner = $user->id == $content->user_id;

        return ($this->can("manage {$content->type}") || ($owner && $this->can("update {$content->type}")));
    }

    public function delete(Authenticatable $user, Content $content)
    {
        $type  = $content->type;
        $owner = $user->id == $content->user_id;

        return ($this->can("manage {$content->type}") || ($owner && $this->can("delete {$content->type}")));
    }

    public function manage(Authenticatable $user, Content $content)
    {
        $type = $content->type;

        return $this->can("manage {$type}");
    }
}
