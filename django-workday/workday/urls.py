"""
URL configuration for workday project.

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/6.0/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))
"""
from django.contrib import admin
from django.urls import path, include
from django.contrib.auth import views as auth_views
from employee_portal import views as employee_views

urlpatterns = [
    path('admin/', admin.site.urls),


    path('', include('workday_portal_app.urls')),
    path('attendance/', include('attendance.urls')),
    path('employees/', include('employee_portal.urls')),


    path("departments/", employee_views.department_list, name="department_list"),
    path("departments/<int:department_id>/", employee_views.department_detail, name="department_detail"),
    path("departments/add/", employee_views.department_create, name="department_create"), 


    path("login/", auth_views.LoginView.as_view(), name="login"),
    path("logout/", auth_views.LogoutView.as_view(), name="logout"),

    path("reports/", employee_views.reports_dashboard, name="reports_dashboard"),

    path("leave/", include("leave_requests.urls")),
]