<h3 class="text-center">Thông tin khách hàng</h3>
<form id="form-customer">
    <div class="form-group">
        <label for="phoneNumber">Số điện thoại</label>
        <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" value="{{ auth()->user()->sdt }}"
            placeholder="Phone number" disabled>
    </div>
    <div class="form-group">
        <label for="ten">Họ và tên</label>
        <input type="text" class="form-control" id="ten" name="ten" placeholder="Nhập tên người nhận">
    </div>
    <div class="form-group">
        <label for="diachi">Địa chỉ</label>
        <input type="text" class="form-control" id="diachi" name="diachi" placeholder="Nhập địa chỉ người nhận">
    </div>
    <div class="submit d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">Đặt hàng</button>
    </div>
</form>
