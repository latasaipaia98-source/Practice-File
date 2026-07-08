from django.shortcuts import render, redirect, get_object_or_404
from django.contrib.auth.decorators import login_required
from django.core.exceptions import PermissionDenied

from employee_portal.models import Employee
from .models import LeaveRequest
from .forms import LeaveRequestForm


def user_can_manage_leave(user):
    return (
        user.is_superuser or
        user.groups.filter(name__in=["HR", "Manager"]).exists()
    )


@login_required
def my_leave_requests(request):
    employee = get_object_or_404(Employee, user=request.user)

    leave_requests = LeaveRequest.objects.filter(
        employee=employee
    ).order_by("-submitted_at")

    return render(request, "leave_requests/my_leave_requests.html", {
        "employee": employee,
        "leave_requests": leave_requests,
    })


@login_required
def apply_leave(request):
    employee = get_object_or_404(Employee, user=request.user)

    if request.method == "POST":
        form = LeaveRequestForm(request.POST)

        if form.is_valid():
            leave_request = form.save(commit=False)
            leave_request.employee = employee
            leave_request.save()

            return redirect("my_leave_requests")
    else:
        form = LeaveRequestForm()

    return render(request, "leave_requests/apply_leave.html", {
        "form": form,
        "employee": employee,
    })


@login_required
def manage_leave_requests(request):
    if not user_can_manage_leave(request.user):
        raise PermissionDenied

    leave_requests = LeaveRequest.objects.select_related(
        "employee",
        "employee__department",
        "reviewed_by",
    ).order_by("status", "-submitted_at")

    return render(request, "leave_requests/manage_leave_requests.html", {
        "leave_requests": leave_requests,
    })


@login_required
def approve_leave(request, leave_id):
    if not user_can_manage_leave(request.user):
        raise PermissionDenied

    leave_request = get_object_or_404(LeaveRequest, id=leave_id)

    if request.method == "POST":
        leave_request.approve(request.user)

    return redirect("manage_leave_requests")


@login_required
def reject_leave(request, leave_id):
    if not user_can_manage_leave(request.user):
        raise PermissionDenied

    leave_request = get_object_or_404(LeaveRequest, id=leave_id)

    if request.method == "POST":
        leave_request.reject(request.user)

    return redirect("manage_leave_requests")