from django.shortcuts import render, redirect, get_object_or_404
from django.utils import timezone
from django.contrib.auth.decorators import login_required

from .models import AttendanceRecord
from employee_portal.models import Employee


@login_required
def dashboard(request):
    employee = get_object_or_404(Employee, user=request.user)

    records = AttendanceRecord.objects.filter(
        employee=employee
    ).order_by("-clock_in_time")[:10]

    active_record = AttendanceRecord.objects.filter(
        employee=employee,
        clock_out_time__isnull=True
    ).first()

    return render(request, "attendance/dashboard.html", {
        "records": records,
        "active_record": active_record,
        "employee": employee,
    })


@login_required
def clock_in(request):
    if request.method == "POST":
        employee = get_object_or_404(Employee, user=request.user)

        active_record = AttendanceRecord.objects.filter(
            employee=employee,
            clock_out_time__isnull=True
        ).first()

        if not active_record:
            AttendanceRecord.objects.create(
                employee=employee,
                clock_in_time=timezone.now()
            )

    return redirect("dashboard")


@login_required
def clock_out(request):
    if request.method == "POST":
        employee = get_object_or_404(Employee, user=request.user)

        active_record = AttendanceRecord.objects.filter(
            employee=employee,
            clock_out_time__isnull=True
        ).first()

        if active_record:
            active_record.clock_out_time = timezone.now()
            active_record.save()

    return redirect("dashboard")