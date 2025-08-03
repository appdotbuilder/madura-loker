import React from 'react';
import { Head, Link, router } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

interface Job {
    id: number;
    title: string;
    description: string;
    store_name: string;
    store_address: string;
    store_phone: string;
    salary_min: number | null;
    salary_max: number | null;
    salary_type: string;
    work_type: string;
    positions_available: number;
    application_deadline: string | null;
    status: string;
    published_at: string;
    category: {
        id: number;
        name: string;
        slug: string;
    };
    user: {
        id: number;
        name: string;
    };
}

interface JobCategory {
    id: number;
    name: string;
    slug: string;
}

interface Props {
    jobs: {
        data: Job[];
        links: Array<{
            url: string | null;
            label: string;
            active: boolean;
        }>;
        meta: {
            current_page: number;
            last_page: number;
            per_page: number;
            total: number;
        };
    };
    categories: JobCategory[];
    filters: {
        category?: string;
        search?: string;
        work_type?: string;
        salary_min?: string;
    };
    auth?: {
        user?: {
            name: string;
            role: string;
        };
    };
    [key: string]: unknown;
}

export default function JobsIndex({ jobs, categories, filters, auth }: Props) {
    const handleSearch = (e: React.FormEvent) => {
        e.preventDefault();
        const formData = new FormData(e.target as HTMLFormElement);
        const searchParams = Object.fromEntries(formData.entries());
        router.get('/jobs', searchParams, { preserveState: true });
    };

    const formatSalary = (min: number | null, max: number | null, type: string) => {
        if (!min && !max) return 'Gaji Negotiable';
        
        const formatNumber = (num: number) => new Intl.NumberFormat('id-ID').format(num);
        const typeLabel = {
            hourly: '/jam',
            daily: '/hari',
            weekly: '/minggu',
            monthly: '/bulan'
        }[type] || '';

        if (min && max && min !== max) {
            return `Rp ${formatNumber(min)} - ${formatNumber(max)}${typeLabel}`;
        } else {
            return `Rp ${formatNumber(min || max || 0)}${typeLabel}`;
        }
    };

    const workTypeLabels = {
        'full-time': 'Full Time',
        'part-time': 'Part Time',
        'contract': 'Kontrak',
        'freelance': 'Freelance'
    };

    return (
        <AppShell>
            <Head title="Lowongan Kerja - Loker Madura" />
            
            <div className="container mx-auto px-4 py-8">
                {/* Header */}
                <div className="mb-8">
                    <h1 className="text-3xl font-bold text-gray-900 mb-2">
                        🔍 Lowongan Kerja Toko Kelontong
                    </h1>
                    <p className="text-gray-600">
                        Temukan pekerjaan impian Anda di toko-toko kelontong terbaik Madura
                    </p>
                </div>

                {/* Search and Filters */}
                <div className="bg-white rounded-lg shadow-sm border p-6 mb-8">
                    <form onSubmit={handleSearch} className="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <Input
                                type="text"
                                name="search"
                                placeholder="Cari lowongan atau nama toko..."
                                defaultValue={filters.search || ''}
                                className="w-full"
                            />
                        </div>
                        
                        <div>
                            <Select name="category" defaultValue={filters.category || ''}>
                                <SelectTrigger>
                                    <SelectValue placeholder="Pilih Kategori" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="">Semua Kategori</SelectItem>
                                    {categories.map((category) => (
                                        <SelectItem key={category.id} value={category.slug}>
                                            {category.name}
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>
                        </div>
                        
                        <div>
                            <Select name="work_type" defaultValue={filters.work_type || ''}>
                                <SelectTrigger>
                                    <SelectValue placeholder="Tipe Pekerjaan" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="">Semua Tipe</SelectItem>
                                    <SelectItem value="full-time">Full Time</SelectItem>
                                    <SelectItem value="part-time">Part Time</SelectItem>
                                    <SelectItem value="contract">Kontrak</SelectItem>
                                    <SelectItem value="freelance">Freelance</SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                        
                        <Button type="submit" className="w-full">
                            🔍 Cari Lowongan
                        </Button>
                    </form>
                </div>

                {/* Create Job Button for Employers */}
                {auth?.user && (auth.user.role === 'employer' || auth.user.role === 'admin') && (
                    <div className="mb-6">
                        <Link href="/jobs/create">
                            <Button className="bg-green-600 hover:bg-green-700">
                                ➕ Posting Lowongan Baru
                            </Button>
                        </Link>
                    </div>
                )}

                {/* Jobs Grid */}
                <div className="grid gap-6">
                    {jobs.data.length === 0 ? (
                        <div className="text-center py-12">
                            <div className="text-6xl mb-4">😔</div>
                            <h3 className="text-xl font-semibold text-gray-900 mb-2">
                                Tidak ada lowongan ditemukan
                            </h3>
                            <p className="text-gray-600 mb-4">
                                Coba ubah kriteria pencarian Anda atau kembali lagi nanti
                            </p>
                            <Link href="/jobs">
                                <Button variant="outline">
                                    🔄 Reset Filter
                                </Button>
                            </Link>
                        </div>
                    ) : (
                        jobs.data.map((job) => (
                            <div key={job.id} className="bg-white rounded-lg shadow-sm border p-6 hover:shadow-md transition-shadow">
                                <div className="flex justify-between items-start mb-4">
                                    <div className="flex-1">
                                        <div className="flex items-center gap-2 mb-2">
                                            <Badge variant="secondary" className="text-xs">
                                                {job.category.name}
                                            </Badge>
                                            <Badge 
                                                variant="outline" 
                                                className={job.work_type === 'full-time' ? 'border-green-300 text-green-700' : 'border-blue-300 text-blue-700'}
                                            >
                                                {workTypeLabels[job.work_type as keyof typeof workTypeLabels]}
                                            </Badge>
                                        </div>
                                        
                                        <h2 className="text-xl font-bold text-gray-900 mb-2">
                                            <Link 
                                                href={`/jobs/${job.id}`}
                                                className="hover:text-orange-600 transition-colors"
                                            >
                                                {job.title}
                                            </Link>
                                        </h2>
                                        
                                        <div className="flex items-center text-gray-600 mb-2">
                                            <span className="mr-1">🏪</span>
                                            <span className="font-medium">{job.store_name}</span>
                                        </div>
                                        
                                        <div className="flex items-center text-gray-600 mb-3">
                                            <span className="mr-1">📍</span>
                                            <span>{job.store_address}</span>
                                        </div>
                                        
                                        <p className="text-gray-700 line-clamp-2 mb-3">
                                            {job.description}
                                        </p>
                                    </div>
                                    
                                    <div className="text-right ml-4">
                                        <div className="text-lg font-bold text-orange-600 mb-2">
                                            {formatSalary(job.salary_min, job.salary_max, job.salary_type)}
                                        </div>
                                        
                                        {job.positions_available > 1 && (
                                            <div className="text-sm text-gray-600 mb-2">
                                                {job.positions_available} posisi tersedia
                                            </div>
                                        )}
                                        
                                        {job.application_deadline && (
                                            <div className="text-sm text-red-600">
                                                ⏰ Deadline: {new Date(job.application_deadline).toLocaleDateString('id-ID')}
                                            </div>
                                        )}
                                    </div>
                                </div>
                                
                                <div className="flex justify-between items-center pt-4 border-t">
                                    <div className="text-sm text-gray-500">
                                        Diposting {new Date(job.published_at).toLocaleDateString('id-ID')}
                                    </div>
                                    
                                    <div className="flex gap-2">
                                        <Link href={`/jobs/${job.id}`}>
                                            <Button variant="outline" size="sm">
                                                👁️ Lihat Detail
                                            </Button>
                                        </Link>
                                        
                                        {auth?.user?.role === 'job_seeker' && (
                                            <Link href={`/apply?job_id=${job.id}`}>
                                                <Button size="sm" className="bg-orange-600 hover:bg-orange-700">
                                                    📝 Lamar Sekarang
                                                </Button>
                                            </Link>
                                        )}
                                    </div>
                                </div>
                            </div>
                        ))
                    )}
                </div>

                {/* Pagination */}
                {jobs.meta.last_page > 1 && (
                    <div className="flex justify-center mt-8">
                        <div className="flex items-center space-x-2">
                            {jobs.links.map((link, index) => (
                                <Link
                                    key={index}
                                    href={link.url || '#'}
                                    className={`px-3 py-2 rounded-md text-sm font-medium ${
                                        link.active
                                            ? 'bg-orange-600 text-white'
                                            : 'bg-white text-gray-700 hover:bg-gray-50 border'
                                    } ${!link.url ? 'opacity-50 cursor-not-allowed' : ''}`}
                                    dangerouslySetInnerHTML={{ __html: link.label }}
                                />
                            ))}
                        </div>
                    </div>
                )}
            </div>
        </AppShell>
    );
}