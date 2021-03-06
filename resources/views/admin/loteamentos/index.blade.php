@extends("templates.admin")

@section('content')
    <section class="content p-2">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <div class="row">
                    @if(session('return'))
                    <div class="col-12">
                        <div class="alert alert-{{session('return')['success'] ? 'success' : 'warning'}}">
                            {{ session('return')['message'] }}
                        </div>
                    </div>
                    @endif

                    <div class="col col-8">
                        <h4 class="">Loteamentos</h4>
                    </div>
                    <div class="col col-4 text-right">
                        <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modal-add-loteamento">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        {{-- Modal Add Loteamento --}}
        <div class="modal fade" id="modal-add-loteamento" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('admin.loteamentos.store') }}">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title">Adicionar Loteamento</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label>Nome:</label>
                                <input type="text" name="nome" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Link:</label>
                                <input type="text" name="link" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Descrição:</label>
                                <input type="text" name="descricao" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Área:</label>
                                <input type="number" step="0.1" name="area" class="form-control" max=100000000>
                            </div>
                        </div>
                        <div class="modal-footer text-right">
                            <button type="submit" class="btn btn-primary">Criar Loteamento</button>
                        </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="card-body overflow-auto">
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th style="width: 1%">
                            #
                        </th>
                        <th style="width: 25%">
                            Nome
                        </th>
                        <th style="width: 20%">
                            Link
                        </th>
                        <th style="width: 5%" class="">
                            Nº de Lotes
                        </th>
                        <th style="width: 5%" class="text-center">
                            Lotes Disponíveis
                        </th>
                        <th style="width: 5%">
                            Interessados
                        </th>
                        <th style="width: 20%" class="text-center">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loteamentos as $loteamento)

                        <tr id="r-{{ $loteamento->id }}">
                            <td>
                                {{ $loteamento->id }}
                            </td>
                            <td>
                                <a>
                                    {{ $loteamento->nome }}
                                </a>
                                <br />
                                <small>
                                    Criado em: {{ date('d/m/Y', strtotime($loteamento->created_at)) }}
                                </small>
                            </td>
                            <td>
                                <a href="{{ env('APP_URL') }}/{{ $loteamento->link }}">
                                    {{ env('APP_URL') }}/{{ $loteamento->link }}
                                </a>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-primary">
                                    {{ $loteamento->lotes()->count() }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-success">
                                    {{ $loteamento->lotes()->where('status', 'L')->count() }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-warning">
                                    
                                    {{ $loteamento->interessados()->count() }}
                                </span>
                            </td>
                            <td class="project-actions text-center">
                                <div class="btn-group">

                                    <a class="btn btn-primary btn-sm"
                                    href="{{ route('admin.loteamentos.show', ['loteamento' => $loteamento]) }}">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                    <a class="btn btn-info btn-sm" href="{{route('admin.loteamentos.edit', ['loteamento' => $loteamento->id])}}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Editar
                                    </a>
                                    {{-- <a class="btn btn-danger btn-sm" href="#">
                                        <i class="fas fa-trash"></i> Delete
                                    </a> --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
@endsection
