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
    <h1>Orders</h1>

    <a href="{{ route('orders.create') }}" class="btn btn-primary mb-3">
        Create New Order
    </a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Send to Kitchen Time</th>
                <th>Total Cost</th>
                <th>Status</th>
                <th>Concessions</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->send_to_kitchen_time }}</td>
                    <td>${{ $order->total_cost }}</td>
                    <td>{{ $order->status }}</td>
                    <td>
                        <ul>
                            @foreach($order->concessions as $concession)
                                <li>
                                    {{ $concession->name }} 
                                    (Qty: {{ $concession->pivot->quantity }}) 
                                    - ${{ $concession->price * $concession->pivot->quantity }}
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Are you sure you want to delete this order?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
      </div>
    </div>
    @include('admin.js')
</body>
</html>