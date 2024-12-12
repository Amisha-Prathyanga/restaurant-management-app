<!DOCTYPE html>
<html>
  <head> 
   @include('admin.css')
  </head>
  <body>
      @include('admin.header')
      @include('admin.sidebar')
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
<div class="container">
    <h1>Create New Order</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="concessions">Select Concessions</label>
            <div class="concession-list">
                @foreach($concessions as $concession)
                    <div class="concession-item">
                        <input type="checkbox" 
                               name="concessions[{{ $concession->id }}]" 
                               id="concession-{{ $concession->id }}"
                               value="1">
                        <label for="concession-{{ $concession->id }}">
                            {{ $concession->name }} - ${{ $concession->price }}
                        </label>
                        <input type="number" 
                               name="concessions_quantity[{{ $concession->id }}]" 
                               min="1" 
                               value="1"
                               class="form-control quantity-input">
                    </div>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <label for="send_to_kitchen_time">Send to Kitchen Time</label>
            <input type="datetime-local" 
                   name="send_to_kitchen_time" 
                   class="form-control" 
                   required>
        </div>

        <button type="submit" class="btn btn-primary">Create Order</button>
    </form>
</div>
</div>
      </div>
    </div>
    @include('admin.js')
</body>
</html>