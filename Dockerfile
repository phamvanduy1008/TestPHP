# Sử dụng Apache HTTP Server làm web server
FROM httpd:latest

# Sao chép mã nguồn HTML/CSS/JS vào thư mục mặc định của Apache
COPY ./src/ /usr/local/apache2/htdocs/

# Expose cổng 80
EXPOSE 80
