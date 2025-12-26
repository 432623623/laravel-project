<x-profile :sharedData="$sharedData" doctitle="{{$sharedData['username']}}'s Profle">  
      <div class="list-group">
        @foreach($posts as $post)
          <x-post :post="$post" hideAuthor/>
        @endforeach        
      </div>
</x-profile>