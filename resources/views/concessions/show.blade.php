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
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Concession Details</h3>
            <div>
                <a href="{{ route('concessions.edit', $concession->id) }}" 
                   class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('concessions.destroy', $concession->id) }}" 
                      method="POST" 
                      style="display:inline;"
                      onsubmit="return confirm('Are you sure you want to delete this concession?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @if($concession->image)
                        <img src="{{ asset('storage/' . $concession->image) }}" 
                             alt="{{ $concession->name }}" 
                             class="img-fluid rounded"
                        >
                    @else
                        <div class="alert alert-warning">No Image Available</div>
                    @endif
                </div>
                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tr>
                            <th>ID</th>
                            <td>{{ $concession->id }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ $concession->name }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{ $concession->description ?? 'No description' }}</td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td>${{ number_format($concession->price, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge 
                                    {{ $concession->status == 'active' ? 'badge-success' : 'badge-danger' }}
                                ">
                                    {{ ucfirst($concession->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $concession->created_at->format('d M Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Last Updated</th>
                            <td>{{ $concession->updated_at->format('d M Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('concessions.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Concessions
            </a>
        </div>
    </div>
</div>
</div>
      </div>
    </div>
    @include('admin.js')
</body>
</html>