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
            <h3 class="card-title">Concessions Management</h3>
            <a href="{{ route('concessions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Concession
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($concessions as $concession)
                    <tr>
                        <td>{{ $concession->id }}</td>
                        <td>
                            @if($concession->image)
                                <img src="{{ asset('storage/' . $concession->image) }}" 
                                     alt="{{ $concession->name }}" 
                                     style="max-width: 100px; max-height: 100px;"
                                >
                            @else
                                No Image
                            @endif
                        </td>
                        <td>{{ $concession->name }}</td>
                        <td>{{ Str::limit($concession->description, 50) }}</td>
                        <td>${{ number_format($concession->price, 2) }}</td>
                        <td>
                            <span class="badge 
                                {{ $concession->status == 'active' ? 'badge-success' : 'badge-danger' }}
                            ">
                                {{ ucfirst($concession->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                {{-- Show Button --}}
                                <a href="{{ route('concessions.show', $concession->id) }}" 
                                   class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- Edit Button --}}
                                <a href="{{ route('concessions.edit', $concession->id) }}" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- Delete Button --}}
                                <form action="{{ route('concessions.destroy', $concession->id) }}" 
                                      method="POST" 
                                      style="display:inline;"
                                      onsubmit="return confirm('Are you sure you want to delete this concession?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

   
        </div>
    </div>
</div>
</div>
      </div>
    </div>
    @include('admin.js')
</body>
</html>

@push('scripts')
<script>
    // Optional: Add any additional JavaScript for the index page
    $(document).ready(function() {
        // Example: Confirm delete action
        $('.btn-delete').on('click', function(e) {
            if (!confirm('Are you sure you want to delete this concession?')) {
                e.preventDefault();
            }
        });
    });
</script>
@endpush