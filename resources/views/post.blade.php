@extends('layouts.frontend.app')
@section('content')
    <!-- Start top-section Area -->
    <section class="top-section-area section-gap">
      <div class="container">
        <div class="row justify-content-between align-items-center d-flex">
          <div class="col-lg-8 top-left">
            <h1 class="text-white mb-20">Post Details</h1>
            <ul>
              <li>
                <a href="{{ route('home') }}">Home</a
                ><span class="lnr lnr-arrow-right"></span>
              </li>
              <li>
                <a href="{{ route('categories') }}">Category</a
                ><span class="lnr lnr-arrow-right"></span>
              </li>
              <li><a href="{{ route('post', $post->slug) }}">Post</a></li>
            </ul>
          </div>
        </div>
      </div>
    </section>
    <!-- End top-section Area -->

    <!-- Start post Area -->
    <div class="post-wrapper pt-100">
      <!-- Start post Area -->
      <section class="post-area">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <div class="single-page-post">
                <img class="img-fluid" src="{{ asset('storage/post/'. $post->image) }}" alt="{{ $post->image }}" />
                <div class="top-wrapper">
                  <div class="row d-flex justify-content-between">
                    <h2 class="col-lg-8 col-md-12 text-uppercase">
                      {{ $post->title }}
                    </h2>
                    <div
                      class="col-lg-4 col-md-12 right-side d-flex justify-content-end"
                    >
                      <div class="desc">
                        <h2>{{ $post->user->name }}</h2>
                        <h3>{{ $post->created_at->diffForHumans() }}</h3>
                      </div>
                      <div class="user-img">
                        <img src="{{ asset('storage/user/'. $post->user->image) }}" alt="{{ $post->user->image }}" width="50px" />
                      </div>
                    </div>
                  </div>
                  <h4 class="text-muted">{{ $post->category->name }}</h4>
                </div>
                <div class="tags">
                  <ul>
                    @foreach ($post->tags as $tag)
                    <li><a href="#">{{ $tag->name }}</a></li>
                    @endforeach
                  </ul>
                </div>
                <div class="single-post-content">
                  {!! $post->body !!}
                </div>
                <div class="bottom-wrapper">
                  <div class="row">
                    <div class="col-lg-4 single-b-wrap col-md-12">
                      @guest
                          <i class="fa fa-heart-o" aria-hidden="true"></i> 
                          Like this Post
                          @else
                          <a href="#" onclick="document.getElementById('like-form-{{ $post->id }}').submit();"><i class="fa fa-heart" aria-hidden="true" style="color:{{Auth::user()->likedPosts()->where('post_id', $post->id)->count() > 0 ? 'red' : ''}}"></i></a> {{ $post->likedUsers()->count() }} Like this Post
                          <form action="{{ route('like-post', $post->id) }}" method="POST" style="display:none" id="like-form-{{ $post->id }}">
                            @csrf
                          </form>
                      @endguest
                    </div>
                    <div class="col-lg-4 single-b-wrap col-md-12">
                      <i class="fa fa-comment-o" aria-hidden="true"></i> {{ $post->likedUsers()->count() }}
                      comments
                    </div>
                    <div class="col-lg-4 single-b-wrap col-md-12">
                      <ul class="social-icons">
                        <li>
                          <a href="#"
                            ><i class="fa fa-facebook" aria-hidden="true"></i
                          ></a>
                        </li>
                        <li>
                          <a href="#"
                            ><i class="fa fa-twitter" aria-hidden="true"></i
                          ></a>
                        </li>
                        <li>
                          <a href="#"
                            ><i class="fa fa-dribbble" aria-hidden="true"></i
                          ></a>
                        </li>
                        <li>
                          <a href="#"
                            ><i class="fa fa-behance" aria-hidden="true"></i
                          ></a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>

                <!-- Start comment-sec Area -->
                <section class="comment-sec-area pt-80 pb-80">
                  <div class="container">
                    <div class="row flex-column">
                      <h5 class="text-uppercase pb-80">05 Comments</h5>
                      <br/>
                      <div class="comment">

                        @foreach ($post->comments as $comment)
                      <div class="comment">
                        <div class="comment-list">
                          <div class="single-comment justify-content-between d-flex">
                            <div class="user justify-content-between d-flex">
                              <div class="thumb">
                                <img src="{{ asset('storage/user/'. $comment->user->image) }}" alt="" width="50px"/>
                              </div>
                              <div class="desc">
                                <h5><a href="#">{{ $comment->user->name }}</a></h5>
                                <p class="date">{{ $comment->created_at->format('D, d M Y H:i') }}</p>
                                <p class="comment">
                                  {{ $comment->comment }}
                                </p>
                              </div>
                            </div>
                            <div class="">
                              <button class="btn-reply text-uppercase" id="reply-btn" 
                                onclick="showReplyForm('{{ $comment->id }}','{{ $comment->user->name }}')">reply 1</button>
                            </div>
                          </div>
                        </div>
                        @if ($comment->replies->count() > 0)
                            @foreach ($comment->replies as $reply)
                        <div class="comment-list left-padding">
                          <div
                            class="single-comment justify-content-between d-flex">
                            <div class="user justify-content-between d-flex">
                              <div class="thumb">
                                <img src="{{asset('storage/user/'. $reply->user->image)}}" alt="" width="50px"/>
                              </div>
                              <div class="desc">
                                <h5><a href="#">{{$reply->user->name}}</a></h5>
                                <p class="date">{{ $reply->created_at->format('D, d M Y H:i') }}</p>
                                <p class="comment">
                                  {{$reply->message}}
                                </p>
                              </div>
                            </div>
                            <div class="">
                              <button class="btn-reply text-uppercase" id="reply-btn" 
                                onclick="showReplyForm('{{$comment->id}}','{{$reply->user->name}}')">reply 1</button>
                            </div>
                          </div>
                        </div> 
                      @endforeach
                        @else
                            
                        @endif
                        <div class="comment-list left-padding" id="reply-form-{{$comment->id}}" style="display: none">
                          <div
                            class="single-comment justify-content-between d-flex">
                            <div class="user justify-content-between d-flex">
                              <div class="thumb">
                                <img src="img/asset/c2.jpg" alt="" />
                              </div>
                              <div class="desc">
                                <h5><a href="#">Goerge Stepphen</a></h5>
                                <p class="date">December 4, 2017 at 3:12 pm</p>
                                <div class="row flex-row d-flex">
                                <form action="{{ route('reply.store', $comment->id) }}" method="POST">
                                @csrf
                                  <div class="col-lg-12">
                                    <textarea
                                      id="reply-form-{{$comment->id}}-text"
                                      cols="60"
                                      rows="2"
                                      class="form-control mb-10"
                                      name="message"
                                      placeholder="Messege"
                                      onfocus="this.placeholder = ''"
                                      onblur="this.placeholder = 'Messege'"
                                      required=""
                                    ></textarea>
                                  </div>
                                  <button type="submit" class="btn-reply text-uppercase ml-3">Reply</button>
                                </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                        @endforeach
                        {{-- <div class="comment-list left-padding">
                          <div
                            class="single-comment justify-content-between d-flex"
                          >
                            <div class="user justify-content-between d-flex">
                              <div class="thumb">
                                <img src="img/asset/c3.jpg" alt="" />
                              </div>
                              <div class="desc">
                                <h5><a href="#">Sally Sally</a></h5>
                                <p class="date">December 4, 2017 at 3:12 pm</p>
                                <p class="comment">
                                  @Emilly Blunt Never say goodbye till the end comes!
                                </p>
                              </div>
                            </div>
                            <div class="">
                              <button class="btn-reply text-uppercase" id="reply-btn" 
                                onclick="showReplyForm('1','Sally Sally')">reply 1</button
                              >
                            </div>
                          </div>
                        </div>
                        <div class="comment-list left-padding" id="reply-form-1" style="display: none">
                          <div
                            class="single-comment justify-content-between d-flex"
                          >
                            <div class="user justify-content-between d-flex">
                              <div class="thumb">
                                <img src="img/asset/c2.jpg" alt="" />
                              </div>
                              <div class="desc">
                                <h5><a href="#">Goerge Stepphen</a></h5>
                                <p class="date">December 4, 2017 at 3:12 pm</p>
                                <div class="row flex-row d-flex">
                                <form action="#" method="POST">
                                  <div class="col-lg-12">
                                    <textarea
                                      id="reply-form-1-text"
                                      cols="60"
                                      rows="2"
                                      class="form-control mb-10"
                                      name="message"
                                      placeholder="Messege"
                                      onfocus="this.placeholder = ''"
                                      onblur="this.placeholder = 'Messege'"
                                      required=""
                                    ></textarea>
                                  </div>
                                  <button type="submit" class="btn-reply text-uppercase ml-3">Reply</button>
                                </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div> --}}
                      </div>
                    </div>
                  </div>
                </section>
                <!-- End comment-sec Area -->

                <!-- Start commentform Area -->
                <section class="commentform-area pb-120 pt-80 mb-100">
                @guest
                  <div class="container">
                    <h2>Please Login in to comment</h2>
                  </div>   
                @else 
                  <div class="container">
                    <h5 class="text-uppercas pb-50">Leave a Reply</h5>
                    <div class="row flex-row d-flex">
                      <div class="col-lg-12">
                      <form action="{{ route('comment.store', $post->id) }}" method="POST">
                        @csrf
                        <textarea
                          class="form-control mb-10"
                          name="comment"
                          placeholder="Messege"
                          onfocus="this.placeholder = ''"
                          onblur="this.placeholder = 'Messege'"
                          required=""
                        ></textarea>
                        <button type="submit" class="primary-btn mt-20">Comment</button>
                      </form>
                      </div>
                    </div>
                  </div>
                  @endguest
                </section>
                <!-- End commentform Area -->
              </div>
            </div>
            @include('layouts.frontend.partials.sidebar')
          </div>
        </div>
      </section>
      <!-- End post Area -->
    </div>
    <!-- End post Area -->
@endsection
@push('footer')
    <script type="text/javascript">
    function showReplyForm(commentId,user) {
      var x = document.getElementById(`reply-form-${commentId}`);
      var input = document.getElementById(`reply-form-${commentId}-text`);

      if (x.style.display === "none") {
        x.style.display = "block";
        input.innerText=`@${user} `;

      } else {
        x.style.display = "none";
      }
    }

    </script>
@endpush