@extends('layouts.app')
@section('title')
    Khách hàng
@endsection
@section('action')
    <div class="col-12">
        <a href="{{route('customer.add')}}" class="btn btn-sm btn-primary">Thêm khách hàng</a>
    </div>
@endsection
@section('breadcrumb')
    Danh sách khách hàng
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <form class="ms-auto position-relative">
                    <div class="row col-12">
                        <div class="col-5">
                            <select name="area_id" class="form-select">
                                <option selected="" value="">Chọn khu vực...</option>
                                @foreach($areas as $areaId => $areaName)
                                    <option value="{{ $areaId }}" @if(intval(request('area_id')) === $areaId) selected @endif>{{ $areaName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-7">
                            <div class="ms-auto position-relative">
                                <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-search"></i></div>
                                <input name="query" value="{{ request('query') }}" class="form-control ps-5" type="text" placeholder="Tìm kiếm...">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive mt-3">
                <table class="table align-middle">
                    <thead class="table-secondary">
                    <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>Tên</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Khu vực</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($customers->isEmpty())
                        <tr><td colspan="7" class="text-center">Không tìm thấy dữ liệu</td></tr>
                    @else
                    @foreach($customers as $key => $customer)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->customer_name }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->address }}</td>
                            <td>{{ $areas[$customer->area_id] ?? '' }}</td>
                            <td>
                                <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                    <a href="{{route('customer.detail', $customer->id)}}" class="text-primary"
                                       data-bs-toggle="tooltip"
                                       data-bs-placement="bottom" title="Xem"><i class="bi bi-eye-fill"></i></a>
                                    <a href="{{route('customer.edit', $customer->id)}}" class="text-warning"
                                       data-bs-toggle="tooltip"
                                       data-bs-placement="bottom"
                                       title="Chỉnh sửa">
                                        <i class="bi bi-pencil-fill"></i></a>
                                        <form class="d-none" id="formDeleteCustomer{{$customer->id}}" action="{{ route('customer.delete', $customer->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <a href="javascript:;" id="deleteCustomerModalBtn" class="text-danger pointer-event"
                                                data-bs-tooltip="tooltip"
                                                data-bs-toggle="modal"
                                                data-bs-placement="bottom" title="Xóa"
                                                data-bs-target="#deleteCustomerModal" data-customer-id="{{$customer->id}}">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-12">
                    {{ $customers->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteCustomerModal" tabindex="-1" aria-labelledby="deleteCustomerModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCustomerModalLabel">Xóa khách hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Bạn có chắc muốn xóa khách hàng này?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button id="deleteCustomer" type="button" class="btn btn-danger">Xóa</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="js/customer/index.js"></script>
@endsection
