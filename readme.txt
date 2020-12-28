เนื่องจากปญหาการถูกบล็อค จึงแก้ปัญหาดังนี้

client ---> ipspiderbroker(วางที่ server csd) ---> ipspiderws(วางที่ heroku) สร้างหลายๆ แอพ

ส่วนนี้คือ ipspiderbroker

ข้อดี
ถ้า ipspiderws ถูกบล็อคก็ให้ลบแล้วสร้างใหม่
จากนั้นให้มาแก้ไขโค้ดที่ipspiderbroker  เพื่อชี้ไปที่แอพใหม่

ส่วนโค้ที่ client ไม่ต้องแก้ไข