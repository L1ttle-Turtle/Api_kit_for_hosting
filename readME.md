//Api kit này bao gồm front-end và back-end trong 1 thư mục chỉ cần cài vào và sử dụng 

Front-end bao gồm 
1 giao diện dashboard admin bao gồm các chức năng như tạo key với toàn quyền, tạo tài khoản cấp thấp hơn với các giới hạn nhất định (chỉ có thể xem dữ liệu), tạo các project với các bảng giới hạn cột/hàng, giám sát Api log của user.
1 giao diên dashboard user bao gồm các chức năng tạo key của project trong thẩm quyền, quản lý được các key đã tạo , gia hạn key theo kiểu request lên admin, quản lý api log.

Back-end bao gồm 
1 Xác thực api key
2 Chống flood request
3 Xác định route 
4 Xác định log của user api key
