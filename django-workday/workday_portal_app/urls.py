from django.contrib import admin
from django.urls import path, include
from employee_portal import views as employee_views

urlpatterns = [
    path("admin/", admin.site.urls),
    path("attendance/", include("attendance.urls")),
    path("employees/", include("employee_portal.urls")),

    path("departments/", employee_views.department_list, name="department_list"),
    path("departments/<int:department_id>/", employee_views.department_detail, name="department_detail"),

    path("reports/", employee_views.reports_dashboard, name="reports_dashboard"),
]