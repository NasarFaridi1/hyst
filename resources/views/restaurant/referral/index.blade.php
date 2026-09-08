@extends('layouts.app')

@section('content')

<style>
    .ref-card {
        background: #ffffff;
        border: 1px solid #E5E7EB;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        padding: 24px;
    }

    .ref-label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #374151;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 6px;
    }

    .ref-input, .ref-select {
        width: 100%;
        background-color: #ffffff !important;
        border: 1.5px solid #D1D5DB !important;
        border-radius: 10px !important;
        padding: 10px 14px !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        color: #111827 !important;
        outline: none !important;
        transition: all 0.2s ease !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03) !important;
    }

    .ref-input:focus, .ref-select:focus {
        border-color: #C25A2A !important;
        box-shadow: 0 0 0 3.5px rgba(194, 90, 42, 0.15) !important;
    }

    .ref-help {
        font-size: 12px;
        color: #6B7280;
        margin-top: 4px;
        display: block;
    }

    .ref-btn-primary {
        background-color: #C25A2A;
        color: #ffffff;
        font-weight: 700;
        font-size: 14px;
        padding: 12px 24px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: background-color 0.2s, transform 0.1s;
        box-shadow: 0 4px 12px rgba(194, 90, 42, 0.25);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .ref-btn-primary:hover {
        background-color: #A54A1F;
    }

    .stat-badge-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    /* Custom Toggle Switch */
    .switch-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #FFF5F0;
        border: 1.5px solid #FAD7C8;
        padding: 16px 20px;
        border-radius: 14px;
    }

    .switch-label-title {
        font-size: 15px;
        font-weight: 700;
        color: #111827;
    }

    .switch-label-desc {
        font-size: 12.5px;
        color: #6B7280;
        margin-top: 2px;
    }

    .toggle-checkbox {
        display: none;
    }

    .toggle-switch {
        position: relative;
        width: 52px;
        height: 28px;
        background-color: #D1D5DB;
        border-radius: 999px;
        cursor: pointer;
        transition: background-color 0.25s ease;
        display: inline-block;
    }

    .toggle-switch::after {
        content: '';
        position: absolute;
        top: 3px;
        left: 3px;
        width: 22px;
        height: 22px;
        background-color: #ffffff;
        border-radius: 50%;
        transition: transform 0.25s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .toggle-checkbox:checked + .toggle-switch {
        background-color: #C25A2A;
    }

    .toggle-checkbox:checked + .toggle-switch::after {
        transform: translateX(24px);
    }
</style>

<div style="max-width: 1200px; margin: 0 auto; padding-bottom: 60px;">

    <!-- Page Header -->
    <div style="margin-bottom: 24px;">
        <h2 style="font-family: 'Poppins', sans-serif; font-size: 24px; font-weight: 800; color: #111827; margin: 0; display: flex; align-items: center; gap: 10px;">
            <span style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #FFF5F0; border-radius: 10px; color: #C25A2A;">🎁</span>
            Restaurant Referral Program Settings
        </h2>
        <p style="font-size: 14px; color: #6B7280; margin-top: 6px;">
            Configure how your customers refer their friends to order from your restaurant. Set referee discounts, minimum order requirements, and referrer rewards!
        </p>
    </div>

    @if(session('success'))
        <div style="background: #ECFDF5; border: 1.5px solid #10B981; color: #065F46; padding: 14px 18px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px; font-size: 14px; font-weight: 600;">
            <span style="font-size: 18px;">✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Main Grid: Settings & Overview Sidebar -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">

        <!-- Form Card (Left Column) -->
        <div class="ref-card">
            <div style="border-bottom: 1px solid #E5E7EB; padding-bottom: 16px; margin-bottom: 20px;">
                <h3 style="font-family: 'Poppins', sans-serif; font-size: 17px; font-weight: 700; color: #111827; margin: 0; display: flex; align-items: center; gap: 8px;">
                    ⚙️ Referral Settings & Rules
                </h3>
            </div>

            <form action="{{ route('restaurant.referral.settings.update') }}" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
                @csrf

                <!-- Enable/Disable Switch -->
                <div class="switch-container">
                    <div>
                        <div class="switch-label-title">Referral Program Status</div>
                        <div class="switch-label-desc">Enable or pause customer referrals for your restaurant</div>
                    </div>
                    <div>
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" id="referral_is_active" name="is_active" value="1" class="toggle-checkbox" {{ ($setting->is_active ?? 1) ? 'checked' : '' }}>
                        <label for="referral_is_active" class="toggle-switch"></label>
                    </div>
                </div>

                <!-- Grid Row: Friend's Discount -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div>
                        <label class="ref-label">Friend's Discount Type</label>
                        <select name="referee_discount_type" class="ref-select">
                            <option value="fixed" {{ ($setting->referee_discount_type ?? 'fixed') == 'fixed' ? 'selected' : '' }}>Fixed Amount (£)</option>
                            <option value="percentage" {{ ($setting->referee_discount_type ?? '') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                        </select>
                        <span class="ref-help">Discount the referred friend receives at checkout.</span>
                    </div>

                    <div>
                        <label class="ref-label">Friend's Discount Value</label>
                        <input type="number" step="0.01" name="referee_discount_value" value="{{ old('referee_discount_value', $setting->referee_discount_value ?? 5.00) }}" required class="ref-input" placeholder="e.g. 5.00">
                        <span class="ref-help">e.g., 5.00 for £5 off or 15 for 15% off.</span>
                    </div>
                </div>

                <!-- Minimum Order Subtotal -->
                <div>
                    <label class="ref-label">Minimum Order Subtotal (£)</label>
                    <input type="number" step="0.01" name="min_order_amount" value="{{ old('min_order_amount', $setting->min_order_amount ?? 10.00) }}" required class="ref-input" placeholder="e.g. 10.00">
                    <span class="ref-help">Minimum cart value required for friend to apply referral code.</span>
                </div>

                <!-- Grid Row: Referrer's Reward -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div>
                        <label class="ref-label">Referrer's Reward Type</label>
                        <select name="referrer_reward_type" class="ref-select">
                            <option value="fixed" {{ ($setting->referrer_reward_type ?? 'fixed') == 'fixed' ? 'selected' : '' }}>Fixed Coupon (£)</option>
                            <option value="percentage" {{ ($setting->referrer_reward_type ?? '') == 'percentage' ? 'selected' : '' }}>Percentage Coupon (%)</option>
                        </select>
                        <span class="ref-help">Reward earned by referrer after friend's order completes.</span>
                    </div>

                    <div>
                        <label class="ref-label">Referrer's Reward Value</label>
                        <input type="number" step="0.01" name="referrer_reward_value" value="{{ old('referrer_reward_value', $setting->referrer_reward_value ?? 5.00) }}" required class="ref-input" placeholder="e.g. 5.00">
                        <span class="ref-help">e.g., 5.00 for £5 reward coupon.</span>
                    </div>
                </div>

                <div style="padding-top: 16px; border-top: 1px solid #E5E7EB; text-align: right;">
                    <button type="submit" class="ref-btn-primary">
                        💾 Save Referral Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Sidebar Summary Cards (Right Column) -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <div class="ref-card">
                <h4 style="font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 700; color: #111827; margin: 0 0 16px 0; text-transform: uppercase; letter-spacing: 0.03em;">
                    📊 Referral Overview
                </h4>
                
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 14px; background: #F9FAFB; border-radius: 10px;">
                        <span style="font-size: 13px; color: #4B5563; font-weight: 600;">Completed Referrals</span>
                        <span style="font-family: 'Poppins', sans-serif; font-size: 18px; font-weight: 800; color: #111827;">{{ number_format($stats['completed_count'] ?? 0) }}</span>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 14px; background: #FEF3C7; border-radius: 10px;">
                        <span style="font-size: 13px; color: #92400E; font-weight: 600;">Pending Referrals</span>
                        <span style="font-family: 'Poppins', sans-serif; font-size: 18px; font-weight: 800; color: #D97706;">{{ number_format($stats['pending_count'] ?? 0) }}</span>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 14px; background: #ECFDF5; border-radius: 10px;">
                        <span style="font-size: 13px; color: #065F46; font-weight: 600;">Total Rewards Granted</span>
                        <span style="font-family: 'Poppins', sans-serif; font-size: 18px; font-weight: 800; color: #059669;">£{{ number_format($stats['total_rewards'] ?? 0, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- How It Works Helper Card -->
            <div style="background: #FFFBEB; border: 1.5px solid #FCD34D; border-radius: 16px; padding: 20px;">
                <h4 style="font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 700; color: #92400E; margin: 0 0 10px 0; display: flex; align-items: center; gap: 6px;">
                    💡 How It Works For Customers
                </h4>
                <ol style="font-size: 12.5px; color: #78350F; margin: 0; padding-left: 18px; line-height: 1.6;">
                    <li>Customer orders from your restaurant.</li>
                    <li>Customer gets a unique referral code to share with friends.</li>
                    <li>Friend enters code at checkout to get friend's discount.</li>
                    <li>Once friend's order is completed, referrer receives their reward coupon!</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Recent Referral Activity Table -->
    <div class="ref-card" style="margin-top: 28px; padding: 0; overflow: hidden;">
        <div style="padding: 18px 24px; border-bottom: 1px solid #E5E7EB; background: #F9FAFB;">
            <h3 style="font-family: 'Poppins', sans-serif; font-size: 16px; font-weight: 700; color: #111827; margin: 0;">
                📋 Recent Referral Log
            </h3>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13.5px;">
                <thead>
                    <tr style="background: #F3F4F6; color: #4B5563; text-transform: uppercase; font-size: 11px; letter-spacing: 0.05em;">
                        <th style="padding: 12px 20px;">Referrer</th>
                        <th style="padding: 12px 20px;">Referred Friend</th>
                        <th style="padding: 12px 20px;">Order ID</th>
                        <th style="padding: 12px 20px;">Friend Discount</th>
                        <th style="padding: 12px 20px;">Referrer Reward</th>
                        <th style="padding: 12px 20px;">Status</th>
                        <th style="padding: 12px 20px;">Date</th>
                    </tr>
                </thead>
                <tbody style="color: #1F2937;">
                    @forelse($usages as $usage)
                        <tr style="border-bottom: 1px solid #F3F4F6;">
                            <td style="padding: 14px 20px; font-weight: 600;">{{ $usage->referrer->name ?? 'User #'.$usage->referrer_id }}</td>
                            <td style="padding: 14px 20px;">{{ $usage->referee->name ?? 'User #'.$usage->referee_id }}</td>
                            <td style="padding: 14px 20px; font-weight: 600;">#{{ $usage->referee_order_id }}</td>
                            <td style="padding: 14px 20px; color: #059669; font-weight: 700;">£{{ number_format($usage->referee_discount_amount, 2) }}</td>
                            <td style="padding: 14px 20px; color: #2563EB; font-weight: 700;">£{{ number_format($usage->referrer_reward_amount, 2) }}</td>
                            <td style="padding: 14px 20px;">
                                @if($usage->status === 'completed')
                                    <span style="display: inline-block; padding: 4px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; background: #D1FAE5; color: #065F46;">Completed</span>
                                @elseif($usage->status === 'pending')
                                    <span style="display: inline-block; padding: 4px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; background: #FEF3C7; color: #92400E;">Pending Completion</span>
                                @else
                                    <span style="display: inline-block; padding: 4px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; background: #FEE2E2; color: #991B1B;">Cancelled</span>
                                @endif
                            </td>
                            <td style="padding: 14px 20px; font-size: 12px; color: #6B7280;">{{ $usage->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding: 32px; text-align: center; color: #9CA3AF; font-size: 14px;">
                                No referral activity recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($usages->hasPages())
            <div style="padding: 16px 24px; border-top: 1px solid #E5E7EB;">
                {{ $usages->links() }}
            </div>
        @endif
    </div>

</div>

@endsection
