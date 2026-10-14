<!-- Modal for POS Item Serial Selection -->
<div class="modal fade" id="modal_pos_serial" tabindex="-1" role="dialog" aria-labelledby="modal_pos_serial_label">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content" style="border-radius: 8px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
      <div class="modal-header" style="background: linear-gradient(135deg, #006837 0%, #047857 100%); color: #ffffff; padding: 14px 18px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 0.9; text-shadow: none;">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="modal_pos_serial_label" style="font-weight: 700; font-size: 16px;">
          <i class="fa fa-barcode"></i> Select Serial Numbers / IMEIs
        </h4>
      </div>
      <div class="modal-body" style="padding: 16px 20px;">
        <input type="hidden" id="pos_serial_row_id" value="">
        <input type="hidden" id="pos_serial_item_id" value="">

        <!-- Item Info Header -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; margin-bottom: 14px;">
          <div style="font-size: 14px; font-weight: 800; color: #0f172a;" id="pos_serial_item_name">-</div>
          <div style="display: flex; gap: 12px; margin-top: 5px; font-size: 12px;">
            <span style="color: #475569;">Cart Qty: <strong id="pos_serial_target_qty" class="text-primary" style="font-size: 13px;">1</strong></span>
            <span style="color: #475569;">Selected Serials: <strong id="pos_serial_selected_count" class="text-success" style="font-size: 13px;">0</strong></span>
          </div>
        </div>

        <!-- Filter and Action Row -->
        <div class="row" style="margin-bottom: 10px;">
          <div class="col-xs-7">
            <div class="input-group input-group-sm">
              <span class="input-group-addon"><i class="fa fa-search"></i></span>
              <input type="text" id="pos_serial_search_filter" class="form-control" placeholder="Search serial/IMEI...">
            </div>
          </div>
          <div class="col-xs-5 text-right">
            <button type="button" class="btn btn-default btn-xs" onclick="pos_serial_auto_pick_first_n()" style="font-weight: 600;">
              <i class="fa fa-magic text-primary"></i> Auto-Pick
            </button>
            <button type="button" class="btn btn-default btn-xs" onclick="pos_serial_clear_selection()" style="font-weight: 600;">
              <i class="fa fa-times text-danger"></i> Clear
            </button>
          </div>
        </div>

        <!-- Available Serials Checkbox List -->
        <label style="font-size: 12px; color: #334155; margin-bottom: 4px;">Available Serial Numbers:</label>
        <div id="pos_serial_checkbox_container" style="max-height: 200px; overflow-y: auto; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px 10px; background: #ffffff; margin-bottom: 14px;">
          <!-- Dynamically populated with serial checkboxes -->
        </div>

        <!-- Manual Input / Custom Serials -->
        <div class="form-group" style="margin-bottom: 0;">
          <label for="pos_serial_manual_text" style="font-size: 12px; color: #334155;">
            Selected Serials (Comma separated or add custom):
          </label>
          <textarea id="pos_serial_manual_text" class="form-control" rows="2" style="font-size: 12px; font-family: monospace; resize: vertical;" placeholder="e.g. SN001, SN002"></textarea>
          <small class="text-muted" style="font-size: 11px;">You can check items above or manually type/scan serials here.</small>
        </div>
      </div>
      <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 10px 18px;">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" onclick="pos_serial_apply_selection()" style="font-weight: 700; background: #006837; border-color: #006837;">
          <i class="fa fa-check"></i> Apply Serials
        </button>
      </div>
    </div>
  </div>
</div>
