from django.shortcuts import render, get_object_or_404, redirect
from django.db.models import Count
from django.contrib.auth.decorators import login_required, permission_required
from django.core.exceptions import PermissionDenied

from .models import Employee, Department
from .forms import EmployeeForm, DepartmentForm
from attendance.models import AttendanceRecord


# -----------------------------
# EMPLOYEE VIEWS
# -----------------------------

@login_required
def employee_list(request):
    employees = Employee.objects.all().order_by("first_name", "last_name")

    return render(request, "employee_portal/employee_list.html", {
        "employees": employees
    })


@login_required
def employee_detail(request, employee_id):
    employee = get_object_or_404(Employee, id=employee_id)

    attendance_records = AttendanceRecord.objects.filter(
        employee=employee
    ).order_by("-clock_in_time")

    return render(request, "employee_portal/employee_detail.html", {
        "employee": employee,
        "attendance_records": attendance_records
    })


@login_required
@permission_required("employee_portal.add_employee", raise_exception=True)
def employee_create(request):
    if request.method == "POST":
        form = EmployeeForm(request.POST)

        if form.is_valid():
            form.save()
            return redirect("employee_list")
    else:
        form = EmployeeForm()

    return render(request, "employee_portal/employee_form.html", {
        "form": form,
        "page_title": "Add Employee"
    })


@login_required
@permission_required("employee_portal.change_employee", raise_exception=True)
def employee_update(request, employee_id):
    employee = get_object_or_404(Employee, id=employee_id)

    if request.method == "POST":
        form = EmployeeForm(request.POST, instance=employee)

        if form.is_valid():
            form.save()
            return redirect("employee_detail", employee_id=employee.id)
    else:
        form = EmployeeForm(instance=employee)

    return render(request, "employee_portal/employee_form.html", {
        "form": form,
        "employee": employee,
        "page_title": "Edit Employee"
    })


@login_required
@permission_required("employee_portal.delete_employee", raise_exception=True)
def employee_delete(request, employee_id):
    employee = get_object_or_404(Employee, id=employee_id)

    if request.method == "POST":
        employee.delete()
        return redirect("employee_list")

    return render(request, "employee_portal/employee_confirm_delete.html", {
        "employee": employee
    })


# -----------------------------
# DEPARTMENT VIEWS
# -----------------------------

@login_required
def department_list(request):
    departments = Department.objects.all().order_by("name")

    return render(request, "employee_portal/department_list.html", {
        "departments": departments
    })


@login_required
def department_detail(request, department_id):
    department = get_object_or_404(Department, id=department_id)

    employees = department.employees.all()

    return render(request, "employee_portal/department_detail.html", {
        "department": department,
        "employees": employees
    })


@login_required
@permission_required("employee_portal.add_department", raise_exception=True)
def department_create(request):
    if request.method == "POST":
        form = DepartmentForm(request.POST)

        if form.is_valid():
            department = form.save()
            return redirect("department_detail", department_id=department.id)
    else:
        form = DepartmentForm()

    return render(request, "employee_portal/department_form.html", {
        "form": form,
        "page_title": "Add Department"
    })


@login_required
@permission_required("employee_portal.change_department", raise_exception=True)
def department_update(request, department_id):
    department = get_object_or_404(Department, id=department_id)

    if request.method == "POST":
        form = DepartmentForm(request.POST, instance=department)

        if form.is_valid():
            form.save()
            return redirect("department_detail", department_id=department.id)
    else:
        form = DepartmentForm(instance=department)

    return render(request, "employee_portal/department_form.html", {
        "form": form,
        "department": department,
        "page_title": "Edit Department"
    })


@login_required
@permission_required("employee_portal.delete_department", raise_exception=True)
def department_delete(request, department_id):
    department = get_object_or_404(Department, id=department_id)

    if request.method == "POST":
        department.delete()
        return redirect("department_list")

    return render(request, "employee_portal/department_confirm_delete.html", {
        "department": department
    })


# -----------------------------
# REPORTS VIEW
# -----------------------------

@login_required
def reports_dashboard(request):
    user_can_view_reports = (
        request.user.is_superuser or
        request.user.groups.filter(name__in=["HR", "Manager"]).exists()
    )

    if not user_can_view_reports:
        raise PermissionDenied

    total_employees = Employee.objects.count()
    active_employees = Employee.objects.filter(is_active=True).count()
    total_departments = Department.objects.count()

    currently_clocked_in = AttendanceRecord.objects.filter(
        clock_out_time__isnull=True
    ).select_related("employee")

    recent_attendance = AttendanceRecord.objects.select_related(
        "employee"
    ).order_by("-clock_in_time")[:10]

    departments = Department.objects.annotate(
        employee_count=Count("employees")
    ).order_by("name")

    return render(request, "employee_portal/reports.html", {
        "total_employees": total_employees,
        "active_employees": active_employees,
        "total_departments": total_departments,
        "currently_clocked_in": currently_clocked_in,
        "recent_attendance": recent_attendance,
        "departments": departments,
    })