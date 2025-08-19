import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';

interface Props {
    stats: {
        total_buyers: number;
        active_buyers: number;
        banned_buyers: number;
        total_sellers: number;
        active_sellers: number;
        banned_sellers: number;
        total_numbers: number;
        available_numbers: number;
        rented_numbers: number;
        pending_invoices: number;
        total_revenue: number;
        monthly_revenue: number;
    };
    recent_buyers: Array<{
        id: number;
        display_name: string;
        telegram_id: string;
        status: string;
        balance: number;
        total_numbers_used: number;
        last_activity: string;
    }>;
    recent_invoices: Array<{
        id: number;
        invoice_number: string;
        total_amount: number;
        status: string;
        buyer: {
            display_name: string;
        };
    }>;
    [key: string]: unknown;
}

export default function Dashboard({ stats, recent_buyers, recent_invoices }: Props) {
    return (
        <AppShell>
            <Head title="Admin Dashboard" />
            
            <div className="space-y-6">
                <div className="flex items-center justify-between">
                    <h1 className="text-2xl font-bold text-gray-900 dark:text-white">
                        📞 Telegram Bot Admin Dashboard
                    </h1>
                </div>

                {/* Stats Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Total Buyers</p>
                                <p className="text-3xl font-bold text-gray-900 dark:text-white">{stats.total_buyers}</p>
                            </div>
                            <div className="bg-blue-100 dark:bg-blue-900 p-3 rounded-full">
                                <span className="text-xl">👥</span>
                            </div>
                        </div>
                        <p className="text-sm text-green-600 dark:text-green-400 mt-2">
                            {stats.active_buyers} active, {stats.banned_buyers} banned
                        </p>
                    </div>

                    <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Total Sellers</p>
                                <p className="text-3xl font-bold text-gray-900 dark:text-white">{stats.total_sellers}</p>
                            </div>
                            <div className="bg-green-100 dark:bg-green-900 p-3 rounded-full">
                                <span className="text-xl">🏪</span>
                            </div>
                        </div>
                        <p className="text-sm text-green-600 dark:text-green-400 mt-2">
                            {stats.active_sellers} active, {stats.banned_sellers} banned
                        </p>
                    </div>

                    <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Phone Numbers</p>
                                <p className="text-3xl font-bold text-gray-900 dark:text-white">{stats.total_numbers}</p>
                            </div>
                            <div className="bg-purple-100 dark:bg-purple-900 p-3 rounded-full">
                                <span className="text-xl">📱</span>
                            </div>
                        </div>
                        <p className="text-sm text-green-600 dark:text-green-400 mt-2">
                            {stats.available_numbers} available, {stats.rented_numbers} rented
                        </p>
                    </div>

                    <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Monthly Revenue</p>
                                <p className="text-3xl font-bold text-gray-900 dark:text-white">${stats.monthly_revenue}</p>
                            </div>
                            <div className="bg-yellow-100 dark:bg-yellow-900 p-3 rounded-full">
                                <span className="text-xl">💰</span>
                            </div>
                        </div>
                        <p className="text-sm text-gray-600 dark:text-gray-400 mt-2">
                            ${stats.total_revenue} total
                        </p>
                    </div>
                </div>

                {/* Quick Actions */}
                <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h2>
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <Link
                            href={route('buyers.index')}
                            className="flex items-center p-4 bg-blue-50 dark:bg-blue-900 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors"
                        >
                            <span className="text-2xl mr-3">👥</span>
                            <div>
                                <p className="font-medium text-blue-900 dark:text-blue-100">Manage Buyers</p>
                                <p className="text-sm text-blue-600 dark:text-blue-300">View, edit, ban/unban</p>
                            </div>
                        </Link>

                        <Link
                            href={route('sellers.index')}
                            className="flex items-center p-4 bg-green-50 dark:bg-green-900 rounded-lg hover:bg-green-100 dark:hover:bg-green-800 transition-colors"
                        >
                            <span className="text-2xl mr-3">🏪</span>
                            <div>
                                <p className="font-medium text-green-900 dark:text-green-100">Manage Sellers</p>
                                <p className="text-sm text-green-600 dark:text-green-300">View, edit, ban/unban</p>
                            </div>
                        </Link>

                        <Link
                            href={route('numbers.index')}
                            className="flex items-center p-4 bg-purple-50 dark:bg-purple-900 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-800 transition-colors"
                        >
                            <span className="text-2xl mr-3">📱</span>
                            <div>
                                <p className="font-medium text-purple-900 dark:text-purple-100">Manage Numbers</p>
                                <p className="text-sm text-purple-600 dark:text-purple-300">View and edit numbers</p>
                            </div>
                        </Link>

                        <Link
                            href={route('invoices.index')}
                            className="flex items-center p-4 bg-yellow-50 dark:bg-yellow-900 rounded-lg hover:bg-yellow-100 dark:hover:bg-yellow-800 transition-colors"
                        >
                            <span className="text-2xl mr-3">💰</span>
                            <div>
                                <p className="font-medium text-yellow-900 dark:text-yellow-100">Billing & Invoices</p>
                                <p className="text-sm text-yellow-600 dark:text-yellow-300">Generate and track</p>
                            </div>
                        </Link>
                    </div>
                </div>

                {/* Recent Activity */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div className="bg-white dark:bg-gray-800 rounded-lg shadow">
                        <div className="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 className="text-lg font-medium text-gray-900 dark:text-white">Recent Buyers</h3>
                        </div>
                        <div className="p-6">
                            {recent_buyers && recent_buyers.length > 0 ? (
                                <div className="space-y-4">
                                    {recent_buyers.map((buyer) => (
                                        <div key={buyer.id} className="flex items-center justify-between">
                                            <div>
                                                <p className="font-medium text-gray-900 dark:text-white">
                                                    {buyer.display_name}
                                                </p>
                                                <p className="text-sm text-gray-500 dark:text-gray-400">
                                                    {buyer.total_numbers_used} numbers used
                                                </p>
                                            </div>
                                            <div className="text-right">
                                                <span className={`inline-flex px-2 py-1 text-xs font-medium rounded-full ${
                                                    buyer.status === 'active' 
                                                        ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                                        : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                                }`}>
                                                    {buyer.status}
                                                </span>
                                                <p className="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                    ${buyer.balance}
                                                </p>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <p className="text-gray-500 dark:text-gray-400 text-center py-8">
                                    No recent buyers
                                </p>
                            )}
                            <div className="mt-4">
                                <Link
                                    href={route('buyers.index')}
                                    className="text-blue-600 hover:text-blue-500 dark:text-blue-400 text-sm font-medium"
                                >
                                    View all buyers →
                                </Link>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 rounded-lg shadow">
                        <div className="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 className="text-lg font-medium text-gray-900 dark:text-white">Pending Invoices</h3>
                        </div>
                        <div className="p-6">
                            {recent_invoices && recent_invoices.length > 0 ? (
                                <div className="space-y-4">
                                    {recent_invoices.map((invoice) => (
                                        <div key={invoice.id} className="flex items-center justify-between">
                                            <div>
                                                <p className="font-medium text-gray-900 dark:text-white">
                                                    {invoice.invoice_number}
                                                </p>
                                                <p className="text-sm text-gray-500 dark:text-gray-400">
                                                    {invoice.buyer.display_name}
                                                </p>
                                            </div>
                                            <div className="text-right">
                                                <p className="font-semibold text-gray-900 dark:text-white">
                                                    ${invoice.total_amount}
                                                </p>
                                                <span className="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                    {invoice.status}
                                                </span>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <p className="text-gray-500 dark:text-gray-400 text-center py-8">
                                    No pending invoices
                                </p>
                            )}
                            <div className="mt-4">
                                <Link
                                    href={route('invoices.index')}
                                    className="text-blue-600 hover:text-blue-500 dark:text-blue-400 text-sm font-medium"
                                >
                                    View all invoices →
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppShell>
    );
}