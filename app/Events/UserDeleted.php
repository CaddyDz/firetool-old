<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserDeleted implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	/**
	 * Information about the user deleted.
	 *
	 * @var $id
	 */
	public int $id;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(int $id)
	{
		$this->id = $id;
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return \Illuminate\Broadcasting\Channel|array
	 */
	public function broadcastOn()
	{
		return ['user-deleted'];
	}

	/**
	* The event's broadcast name.
	*
	* @return string
	*/
	public function broadcastAs()
	{
		return 'user.deleted';
	}
}
