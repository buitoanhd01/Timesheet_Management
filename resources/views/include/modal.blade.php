<div class="loading-effect" style="display: none;">
    <div class="spinner-grow text-primary ms-5" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <div class="spinner-grow text-secondary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <div class="spinner-grow text-success" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <div class="spinner-grow text-danger" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <div class="spinner-grow text-warning" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <div class="spinner-grow text-info" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <div class="spinner-grow text-light" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <div class="spinner-grow text-dark" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
</div>

<div class="modal fade" id="modal_assign_user" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCenterTitle">Assign Account For Employee</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <div class="card">
          <div class="table-responsive text-nowrap" style="min-height: 250px;max-height: 25s0px">
            <form action="" id="form-assign">
              <input type="hidden" id="user_id_hidden" value="">
              <table class="table table-layout-fixed table-bordered">
                <thead class="sticky-top">
                  <tr>
                    <th class="col-1">Select</th>
                    <th class="col-3">Employee Code</th>
                    <th class="col-4">Employee Name</th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="employee_no_account">
                  
                </tbody>
              </table>
            </form>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary mt-4" data-bs-dismiss="modal">
          Close
        </button>
        <button type="button" class="btn btn-primary mt-4" id="btn_save_assign">Save changes</button>
      </div>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="modalRequestexample" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">Leave Request</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Name</label>
            <input
              type="text"
              id="nameBackdrop"
              class="form-control"
              placeholder="Enter Name"
            />
          </div>
        </div>
        <div class="row g-2">
          <div class="col mb-0">
            <label for="emailBackdrop" class="form-label">Email</label>
            <input
              type="text"
              id="emailBackdrop"
              class="form-control"
              placeholder="xxxx@xxx.xx"
            />
          </div>
          <div class="col mb-0">
            <label for="dobBackdrop" class="form-label">DOB</label>
            <input
              type="text"
              id="dobBackdrop"
              class="form-control"
              placeholder="DD / MM / YY"
            />
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <button type="button" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>


<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <form>
        <div class="modal-body">
          <div class="form-group mb-2">
            <label for="currentPassword">Current Password</label>
            <input type="password" class="form-control" id="currentPassword" placeholder="Enter current password">
          </div>
          <div class="form-group mb-2">
            <label for="newPassword">New Password</label>
            <input type="password" class="form-control" id="newPassword" placeholder="Enter new password">
          </div>
          <div class="form-group mb-2">
            <label for="confirmPassword">Confirm New Password</label>
            <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm new password">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
          </button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalRequest" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="leaveRequestModalLabel">Leave Request</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="role_id_hidden" value="">
          <div class="form-group mb-3">
            <label for="leave_type" class="form-label">Leave Type:</label>
            <select class="form-control" id="leave_type">
              <option value="1">Paid Leave</option>
              <option value="2">No Paid Leave</option>
              <option value="3">Sick Leave</option>
              <option value="4">Maternity Leave</option>
            </select>
          </div>
          <div class="form-group mb-3">
            <label for="start_date" class="form-label">Start Time:</label>
            <input type="text" class="form-control datepicker" id="start_date" placeholder="Start Time">
          </div>
          <div class="form-group mb-3">
            <label for="end_date" class="form-label">End Time:</label>
            <input type="text" class="form-control datepicker" id="end_date" placeholder="End Time">
          </div>
          <div class="form-group mb-3">
            <label for="reason" class="form-label">Reason:</label>
            <textarea class="form-control" id="reason" rows="3"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <button type="button" class="btn btn-primary" id="submit-leave-request">Send Request</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalRole" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="leaveRequestModalLabel">Edit Pemission For <span id="role_name" class="text-info text-capitalize"></span></h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <form>
          <table class="table">
            <thead>
              <tr>
                <th>Choose</th>
                <th>Pemission Name</th>
              </tr>
            </thead>
            <tbody id="permission_list">
              
            </tbody>
          </table>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <button type="button" class="btn btn-primary" id="submit-permission">Save</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalEditTime" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="leaveRequestModalLabel">Edit Attendance</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="attendance_id" value="">
          <div class="form-group mb-3">
            <label for="check_in" class="form-label">Check In:</label>
            <input type="text" class="form-control" id="check_in" placeholder="Check In">
          </div>
          <div class="form-group mb-3">
            <label for="check_out" class="form-label">Check out:</label>
            <input type="text" class="form-control" id="check_out" placeholder="Check Out">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <button type="button" class="btn btn-primary" id="submit-edit-attendance">Save</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalShift" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">Edit shift </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <input type="hidden" id="hidden_id" value="">
      <div class="modal-body">
        <div class="row">
          <div class="col mb-1">
            <label for="shift_name" class="form-label">Shift Name</label>
            <input
              type="text"
              id="shift_name"
              class="form-control"
            />
          </div>
        </div>
        <div class="row g-2">
          <div class="col mb-1">
            <label for="shift_start" class="form-label">Shift Start Time</label>
            <input
              type="text"
              id="shift_start"
              class="form-control"
            />
          </div>
          <div class="col mb-1">
            <label for="shift_end" class="form-label">Shift End Time</label>
            <input
              type="text"
              id="shift_end"
              class="form-control"
            />
          </div>
        </div>
        <div class="row g-2">
          <div class="col mb-1">
            <label for="rest_start" class="form-label">Rest Start</label>
            <input
              type="text"
              id="rest_start"
              class="form-control"
            />
          </div>
          <div class="col mb-1">
            <label for="rest_end" class="form-label">Rest End</label>
            <input
              type="text"
              id="rest_end"
              class="form-control"
            />
          </div>
        </div>
        <div class="row g-2">
          <div class="col mb-1">
            <label for="overtime" class="form-label">Overtime Start</label>
            <input
              type="text"
              id="overtime"
              class="form-control"
            />
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <button type="button" class="btn btn-primary" id="btn_save_shift">Save</button>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="modalEditRequest" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="leaveRequestModalLabel">Leave Request</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="hidden_id" value="">
          <div class="form-group mb-3">
            <label for="leave_type" class="form-label">Leave Type:</label>
            <select class="form-control" id="leave_type">
              <option value="1">Paid Leave</option>
              <option value="2">No Paid Leave</option>
              <option value="3">Sick Leave</option>
              <option value="4">Maternity Leave</option>
            </select>
          </div>
          <div class="form-group mb-3">
            <label for="start_date" class="form-label">Start Time:</label>
            <input type="text" class="form-control datepicker" id="start_date" placeholder="Start Time">
          </div>
          <div class="form-group mb-3">
            <label for="end_date" class="form-label">End Time:</label>
            <input type="text" class="form-control datepicker" id="end_date" placeholder="End Time">
          </div>
          <div class="form-group mb-3">
            <label for="reason" class="form-label">Reason:</label>
            <textarea class="form-control" id="reason" rows="3"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <button type="button" class="btn btn-primary" id="edit-leave-request">Send Request</button>
      </div>
    </div>
  </div>
</div>