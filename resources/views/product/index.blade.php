@extends('layouts.app')
@section('title')
    Sản phẩm
@endsection
@section('css')
    {{-- write css this page--}}
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    Danh sách sản phẩm
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="d-flex justify-content-between m-2 row">
                <div class="col-10">
                    <form class="position-relative" id="form-search">
                    <div class="row">
                        <div class="col-4">
                                <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i
                                        class="bi bi-search"></i></div>
                                <input onchange="$('#form-search').submit()" class="form-control ps-5 rounded" type="text"
                                       placeholder="Nhập nội dung tìm kiếm"
                                       name="query" value="{{ request('query') }}">
                        </div>
                        <div class="col-4">
                            <select onchange="$('#form-search').submit()" name="category_id" class="form-select single-select">
                                <option selected="" value="">Chọn danh mục</option>
                                @foreach($categories as $categoryId => $categoryName)
                                    <option value="{{ $categoryId }}"
                                            @if(intval(request('category_id')) === $categoryId) selected @endif>{{ $categoryName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="col-2">
                    <a href="{{route('product.create.show')}}" type="button" class="btn btn-primary float-end">Thêm sản
                        phẩm</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive mt-3">
                        <table class="table align-middle last-child-right">
                            <thead class="table-secondary">
                            <tr>
                                <th>#</th>
                                <th>Hình ảnh</th>
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Danh mục</th>
                                <th>Màu sắc</th>
                                <th>Dung tích</th>
                                <th>Quy cách</th>
                                <th>Đơn vị tính</th>
                                <th>Đơn giá</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($productList && $productList->count() > 0)
                                @php
                                    $currentPage = $productList->currentPage();
                                    $perPage = $productList->perPage();
                                    $currentItem = ($currentPage - 1) * $perPage;
                                @endphp
                                @foreach($productList as $key => $item)
                                    <tr>
                                        <td>{{++$currentItem}}</td>
                                        <td>
                                            @if($item->image_url)
                                                <img src="{{ asset($item->image_url) }}" alt=""
                                                     style="width:50px; height:50px;">
                                            @else
                                                <img src="{{ asset("/storage/images/products/no-image.jpg") }}" alt=""
                                                     style="width:50px; height:50px;">
                                            @endif
                                        </td>
                                        <td>{{$item->product_code}}</td>
                                        <td>{{$item->product_name}}</td>
                                        <td>{{$categories[$item->category_id]}}</td>
                                        <td>{{$item->color}}</td>
                                        <td>{{$item->capacity}}</td>
                                        <td>{{$item->specifications}}</td>
                                        <td>{{$item->unit}}</td>
                                        <td>{{number_format($item->price)}}</td>
                                        <td>
                                            <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                                <a href="{{route('product.detail', $item->id)}}" class="text-primary"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-placement="bottom" title="Xem"><i
                                                        class="bi bi-eye-fill"></i></a>
                                                <a href="{{route('product.edit', $item->id)}}" class="text-warning"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-placement="bottom" title="Chỉnh sửa"><i
                                                        class="bi bi-pencil-fill"></i></a>
                                                <form class="d-none" id="formDeleteProduct{{$item->id}}"
                                                      action="{{ route('product.delete', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <a href="javascript:;" id="deleteProductModalBtn"
                                                   class="text-danger pointer-event"
                                                   data-bs-tooltip="tooltip"
                                                   data-bs-toggle="modal"
                                                   data-bs-placement="bottom" title="Xóa"
                                                   data-bs-target="#deleteProductModal" data-product-id="{{$item->id}}">
                                                    <i class="bi bi-trash-fill"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="11" class="text-center">Không tìm thấy dữ liệu</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        @if($productList && $productList->count() > 0)
                            <div class=" justify-content-center">
                                {!! $productList->links('pagination::bootstrap-5') !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel"
                 aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteProductModalLabel">Xóa sản phẩm</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">Bạn có chắc muốn xóa sản phẩm này?</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                            <button id="deleteProduct" type="button" class="btn btn-danger">Xóa</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="js/product/index.js"></script>
@endsection



