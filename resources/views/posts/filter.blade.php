<html>
<head>
<meta charset="utf-8">
    <title>Posts Search</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body style="padding: 20">
@if(isset($errorMsg))
	<div class="alert alert-error">
		{{ $errorMsg }}
	</div>
@endif
<div>
    <form action="{{ route('filterPosts'); }}" method="POST">
    	@csrf
        <label for="dateSince">Since</label>
        <input type="date" class="form-control w-25" id="dateSince" name="dateSince">
        <label for="dateHence">Hence</label>
        <input type="date" class="form-control w-25" id="dateHence" name="dateHence">
        <label for="postText">Full Post Text</label>
        <input type="text" class="form-control w-25" id="postText" name="postText">
        <br />
        <label class="form-select-label" for="listsSelect">Lists</label>
        <select class="form-select" multiple aria-label="multiple select example" name="lists[]" id="listsSelect">
        @foreach($arrLists as $list)
        	<option value="{{ $list->name }}">{{ $list->name }}</option>
        @endforeach
        </select>
        <label class="form-select-label" for="listsSelect">Social Networks</label>
        <select class="form-select" multiple aria-label="multiple select example" name="socialNetwork[]" id="listsSocialNetwork">
        @foreach($arrSocialNetworks as $socialNetwork)
        	<option value="{{ $socialNetwork->name }}">{{ $socialNetwork->name }}</option>
        @endforeach
        </select>
		<br />
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@if(isset($arrPosts))
<h2>{{ $countPosts }} Posts Listed</h2>
<div>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Date Posted</th>
          <th scope="col">Social Network</th>
          <th scope="col">Link to post</th>
          <th scope="col">Post Text</th>
          <th scope="col">Link to account profile</th>
          <th scope="col">Name</th>
          <th scope="col">Lists</th>
        </tr>
      </thead>
      <tbody>
      	@foreach($arrPosts as $post)
            <tr>
              <th scope="row">{{ $post->date }}</th>
              <td>{{ $post->socialNetwork }}</td>
              <td>{{ $post->postLink }}</td>
              <td>{{ $post->postText }}</td>
              <td>{{ $post->accountLink }}</td>
              <td>{{ $post->postAuthor }}</td>
              <td>
              	<ul>
              		@foreach($post->authorLists as $list)
              			<li>{{$list}}</li>
              		@endforeach
              	</ul>
              </td>
            </tr>
        @endforeach
      </tbody>
    </table>
</div>
@endif
</body>
</html>
