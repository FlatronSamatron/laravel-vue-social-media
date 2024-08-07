# initialization project:

## install laravel version 10 by sail in windows 10:

- `boot docker`
- `use wsl2 terminal`
- `curl -s "https://laravel.build/example-app?php=81" | bash`
- `explorer.exe .` -> open folder in windows
- `./vendor/bin/sail up -d` -> start container
    - `./vendor/bin/sail stop` -> stop container
    - `./vendor/bin/sail down` -> delete container
- `sudo chmod -R 777 .` -> make all files writable
- `composer require laravel/breeze --dev`
- `./vendor/bin/sail bash` -> use bash by sail
- `npm run dev`

## Generate Models and Migrations

- `php artisan make:model Post -m` -> generate model and migration of Posts
- `php artisan make:model PostAttachment -m` -> generate model and migration of PostAttachments
- `php artisan make:model PostReaction -m` -> generate model and migration of PostReactions
- `php artisan make:model Comment -m` -> generate model and migration of Comments
- `php artisan make:model GroupUser -m` -> generate model and migration of GroupUsers
- `php artisan make:model Follower -m` -> generate model and migration of Followers
- `php artisan make:migration add_columns_to_users_table` -> add_columns_to_users_table
- `php artisan migrate` -> crate tables

## Generate Unique Username on Registration

- `composer require spatie/laravel-sluggable` ->  [Generate slugs when saving Eloquent models](https://github.com/spatie/laravel-sluggable)
- add to User model:
    - implements MustVerifyEmail
    - getSlugOptions()
- `localhost:8025` -> mailpit - email verify service
- add to UpdateProfileInformationForm.vue username field
- add to ProfileUpdateRequest.php username field
    - add messages which react to regex

## Create Home Page UI with Tailwind.css

- `php artisan make:controller HomeController` -> generate controller HomeController
- clean unnecessary routes and views

## User Cover & Avatar Image Upload

- `php artisan make:resource UserResource` -> generate resource UserResource
- `npm i @heroicons/vue` -> install package with icons
- to AppServiceProvider.php add JsonResource::withoutWrapping() -> delete wrap data:{} from resources
- `php artisan storage:link` -> The [public/storage] link has been connected to [storage/app/public]
- `Storage::url($this->cover_path)` -> return correct link to storage
- `Storage::disk('public')->delete($user->cover_path)` -> delete previous cover from public storage|disk

## Implement Post Creation

- `php artisan make:controller PostController --model=Post`
- `php artisan make:request Post/UpdatePostRequest`
- `php artisan make:request Post/StorePostRequest`
- `php artisan make:resource PostResource`
- added Relationships in PostModel:
    - `function user(): BelongsTo
      {
      return $this->belongsTo(User::class);
      }`
    - `function group(): BelongsTo
      {
      return $this->belongsTo(Group::class);
      }`
    - `function attachments(): HasMany
      {
      return $this->hasMany(PostAttachment::class);
      }`
- returned posts from HomeController:
    - `return Inertia::render('Home', [
      'posts' => PostResource::collection($posts)
      ]);`

## Updating & Deleting of Posts

in UpdatePostRequest.php authorized user can change only his posts :

- `public function authorize(): bool
  {
  $post = $this->route('post');
  return $post->user_id == auth()->id();
  }`

## Add CKEditor During Post

- [npm install @ckeditor/ckeditor5-vue, npm install ckeditor5](https://ckeditor.com/docs/ckeditor5/latest/getting-started/installation/vuejs-v3.html)

## Uploading Attachments

- `php artisan make:migration add_size_column_to_post_attachments_table`
- `php artisan make:resource PostAttachmentResource`

## Delete and download post attachments

- PostModal.vue cannot update with form.put because it should update post and add new pictures:
    - added in modal _method: ''
    - form._method = 'PUT'
      form.post(route('post.update', post)

- PostController.php deleting files from db:
    - `$attachments = PostAttachment::query()
      ->where('post_id', $post->id)
      ->whereIn('id', $deletedIds)
      ->get();`
    - `foreach ($attachments as $attachment){
      $attachment->delete();
      }`

- PostAttachment.php deleting from storage
    - `protected static function boot()`
      `{ parent::boot();
      static::deleted(function (self $model) {
      Storage::disk('public')->delete($model->path);
      });
      }`

## Implement Reactions on Posts

- `npm i -S axios`
- created axiosClient.js and use [Interceptors](https://axios-http.com/docs/interceptors)
- withCount('reactions') - reactions_count
- added enum PostReactionEnum to validate request

## Writing Comments on Posts

- `php artisan make:resource CommentResource`
- `php artisan make:request Post/UpdateCommentRequest`
- `public function authorize(): bool
  {
  $comment = $this->route('post');
  return $comment->user_id == auth()->id();
  }`

## Comment like/unlike

- `artisan make:migration change_post_reactions_table`










