{!! Form::model($model, [
    'route' => 'user.store', 
    'method' => 'POST',
    'enctype' => 'multipart/form-data'
])!!}

    <div class="form-group">
        <label for="" class="control-label">Name</label>
       <a href="{{ route('user.export') }}" class ="btn btn-success" title="Export">Export</a>
    </div>
    <div class="form-group">
        <label for="" class="control-label">Import</label>
        {!!Form::file('file', null, ['class' => 'form-control', 'id' => 'file']) !!}
    </div>
{!! Form::close() !!}