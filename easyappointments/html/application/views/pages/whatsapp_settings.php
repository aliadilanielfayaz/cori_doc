<?php extend('layouts/backend_layout'); ?>

<?php section('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<?php end_section('styles'); ?>

<?php section('content'); ?>

<div id="whatsapp-settings-page" class="container backend-page">
    <div class="row">
        <div class="col-sm-3 offset-sm-1">
            <?php component('settings_nav'); ?>
        </div>
        <div id="whatsapp-settings" class="col-sm-6">
            <form>
                <fieldset>
                    <div class="d-flex justify-content-between align-items-center border-bottom mb-4 py-2">
                        <h4 class="text-black-50 mb-0 fw-light">
                            <?= lang('whatsapp') ?>
                        </h4>

                        <div>
                            <a href="<?= site_url('integrations') ?>" class="btn btn-outline-primary me-2">
                                <i class="fas fa-chevron-left me-2"></i>
                                <?= lang('back') ?>
                            </a>

                            <?php if (can('edit', PRIV_SYSTEM_SETTINGS)): ?>
                                <button type="button" id="save-settings" class="btn btn-primary">
                                    <i class="fas fa-check-square me-2"></i>
                                    <?= lang('save') ?>
                                </button>
                            <?php endif; ?>

                            <!-- MY code debut -->
                            <?php if (can('edit', PRIV_SYSTEM_SETTINGS)): ?>
    
                                <button type="button" id="send-whatsapp-settings" class="btn btn-outline-primary">
                                    <i class="fab fa-whatsapp me-2 me-2"></i>
                                    <?= lang('send-whatsapp-settings') ?>
                                </button>
                                
                            <?php endif; ?>
                            <!-- My code Fin -->
                        </div>
                    
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label" for="google-analytics-code">
                                    <?= lang('whatsapp_code') ?>
                                </label>
                                <input id="whatsapp-code" placeholder="+ Code du pays Numéro de téléphone (ex: +33 6 12 34 56 78)"
                                       class="form-control" data-field="whatsapp_code">
                                <div class="form-text text-muted">
                                    <small>
                                        <?= lang('whatsapp_code_code_hint') ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php slot('after_primary_appointment_fields'); ?>
                </fieldset>
            </form>
        </div>
    </div>
</div>

<?php end_section('content'); ?>
<?php section('scripts'); ?>

<script src="<?= asset_url('assets/js/utils/url.js') ?>"></script>

<script src="<?= asset_url('assets/js/pages/whatsapp_settings.js') ?>"></script>

<?php end_section('scripts'); ?>

