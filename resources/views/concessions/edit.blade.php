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
        <div class="card-header">
            <h3 class="card-title">Edit Concession</h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('concessions.update', $concession->id) }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control" 
                                   value="{{ old('name', $concession->name) }}" 
                                   required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" 
                                   name="price" 
                                   step="0.01" 
                                   class="form-control" 
                                   value="{{ old('price', $concession->price) }}" 
                                   required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" 
                              class="form-control">{{ old('description', $concession->description) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control">
                                <option value="active" 
                                    {{ old('status', $concession->status) == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="inactive" 
                                    {{ old('status', $concession->status) == 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="image">Update Image</label>
                            <input type="file" name="image" class="form-control-file">
                            
                            @if($concession->image)
                                <div class="mt-2">
                                    <small>Current Image:</small>
                                    <img src="{{ asset('storage/' . $concession->image) }}" 
                                         alt="{{ $concession->name }}" 
                                         style="max-width: 200px; max-height: 200px;"
                                    >
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Concession</button>
                    <a href="{{ route('concessions.index') }}" class="btn btn-secondary ml-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
      </div>
    </div>
    @include('admin.js')
</body>
</html>
