<!-- Add Case Modal -->
<div class="modal fade modal" id="addCaseModal" tabindex="-1" aria-labelledby="addCaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fw-bolder" id="addCaseModalLabel" style="font-size: 25px">Add New Case</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('cases.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="case_title" class="form-label">Case Title:</label>
                        <input type="text" class="form-control" id="case_title" name="case_title" required>
                    </div>

                    <div class="mb-3">
                        <label for="case_type" class="form-label">Case Type:</label>
                        <select class="form-control" id="case_type" name="case_type" style="height: 40px">
                            <option value="Abuse">Abuse</option>
                            <option value="Neglect">Neglect</option>
                            <option value="Support">Support</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="guardian_name" class="form-label">Guardian Name:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="guardian_name" name="guardian_name" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="guardian_contact" class="form-label">Guardian Contact:</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="guardian_contact" name="guardian_contact"
                                required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes:</label>
                        <textarea class="form-control" id="notes" name="notes" rows="4"
                            placeholder="Enter any additional case details..."></textarea>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times-circle"></i> Cancel

                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Edit Case Modal -->
<div class="modal fade" id="editCaseModal" tabindex="-1" aria-labelledby="editCaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fw-bolder" id="editCaseModalLabel" style="font-size: 25px">Edit Case</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCaseForm" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Hidden Case ID -->
                    <input type="hidden" id="case_id" name="id">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_case_title" class="form-label">Case Title:</label>
                                <input type="text" class="form-control" id="edit_case_title" name="case_title"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_case_type" class="form-label">Case Type:</label>
                                <select class="form-control" id="edit_case_type" name="case_type"
                                    style="height: 40px">
                                    <option value="Abuse">Abuse</option>
                                    <option value="Neglect">Neglect</option>
                                    <option value="Support">Support</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_guardian_name" class="form-label">Guardian Name:</label>
                                <input type="text" class="form-control" id="edit_guardian_name"
                                    name="guardian_name" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_guardian_contact" class="form-label">Guardian Contact:</label>
                                <input type="text" class="form-control" id="edit_guardian_contact"
                                    name="guardian_contact" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_status" class="form-label">Status:</label>
                                <select class="form-control" id="edit_status" name="status" style="height: 40px">
                                    <option value="open">Open</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="closed">Closed</option>
                                    <option value="resolved">Resolved</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_notes" class="form-label">Notes:</label>
                                <textarea class="form-control" id="edit_notes" name="notes" rows="2" placeholder="Enter details..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times-circle"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".editCaseBtn").forEach(button => {
            button.addEventListener("click", function() {
                let caseId = this.getAttribute("data-id");
                let caseTitle = this.getAttribute("data-case_title");
                let caseType = this.getAttribute("data-case_type");
                let caseGname = this.getAttribute("data-guardian_name");
                let caseGcontact = this.getAttribute("data-guardian_contact");
                let caseNotes = this.getAttribute("data-notes");
                let caseStatus = this.getAttribute("data-status");

                // Set form action dynamically
                document.getElementById("editCaseForm").action = `/cases/${caseId}`;

                // Populate modal fields
                document.getElementById("case_id").value = caseId;
                document.getElementById("edit_case_title").value = caseTitle;
                document.getElementById("edit_guardian_name").value = caseGname;
                document.getElementById("edit_guardian_contact").value = caseGcontact;
                document.getElementById("edit_notes").value = caseNotes;

                // Set the selected value in the case type dropdown
                let caseTypeDropdown = document.getElementById("edit_case_type");
                for (let option of caseTypeDropdown.options) {
                    if (option.value === caseType) {
                        option.selected = true;
                        break;
                    }
                }

                // Set the selected value in the status dropdown
                let statusDropdown = document.getElementById("edit_status");
                for (let option of statusDropdown.options) {
                    if (option.value === caseStatus) {
                        option.selected = true;
                        break;
                    }
                }
            });
        });
    });
</script>




<script>
    // Set the selected role in dropdown
    let roleDropdown = document.getElementById("edit_role");
    if (roleDropdown) {
        for (let option of roleDropdown.options) {
            if (option.value === userRole) {
                option.selected = true;
                break;
            }
        }
    }
    });
    })
    });
</script>
