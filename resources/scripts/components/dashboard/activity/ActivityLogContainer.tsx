import React, { useEffect, useState } from "react";
import { useTranslation } from "react-i18next";
import { ActivityLogFilters, useActivityLogs } from "@/api/account/activity";
import { useFlashKey } from "@/plugins/useFlash";
import PageContentBlock from "@/components/elements/PageContentBlock";
import tw from "twin.macro";
import FlashMessageRender from "@/components/FlashMessageRender";
import { Link } from "react-router-dom";
import { format, formatDistanceToNowStrict } from "date-fns";
import { ActivityLog } from "@definitions/user";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faScrollOld, faServer, faUserLock } from "@fortawesome/pro-duotone-svg-icons";
import { faUserLock as faUserLockF } from "@fortawesome/free-solid-svg-icons";
import Tooltip from "@/components/elements/tooltip/Tooltip";
import Spinner from "@/components/elements/Spinner";
import styled from "styled-components/macro";
import { useActivityLogFilters } from "@/components/dashboard/activity/ActivityLogFilters";
import ActivityLogEntry from "@/components/elements/activity/ActivityLogEntry";

const Code = styled.code`${tw`px-1 py-0.5 bg-neutral-700 rounded`}`;

export default () => {
    const { t } = useTranslation("dashboard");
    const [filters, setFilters] = useActivityLogFilters();
    const { clearAndAddHttpError } = useFlashKey("account");
    const { data, size, setSize, isValidating, error } = useActivityLogs(filters, {
        revalidateOnMount: true,
        revalidateOnFocus: false,
    });

    useEffect(() => {
        clearAndAddHttpError(error);
    }, [error]);

    return (
        <PageContentBlock title={t("account_activity_log")}>
            <FlashMessageRender byKey={"account"} />
            {(filters.action || filters.ip || filters.timestamp) && (
                <div css={tw`flex justify-end mb-2`}>
                    <Link
                        to={"#"}
                        css={tw`text-xs uppercase tracking-wide no-underline`}
                        onClick={() => setFilters({})}
                    >
                        Clear Filters <FontAwesomeIcon icon={faUserLockF} css={tw`ml-2`} />
                    </Link>
                </div>
            )}
            {!data && isValidating ? (
                <Spinner centered />
            ) : !data?.length ? (
                <p css={tw`text-center text-sm text-neutral-400`}>
                    No activity logs available for this account.
                </p>
            ) : (
                <div>
                    {data.map((activity, index) => (
                        <ActivityLogEntry key={index} activity={activity} />
                    ))}
                    {data.length % 25 === 0 && (
                        <div css={tw`mt-4 flex justify-center`}>
                            <button
                                onClick={() => setSize(size + 1)}
                                disabled={isValidating}
                                css={tw`px-4 py-2 bg-neutral-700 rounded text-sm hover:bg-neutral-600 disabled:opacity-50`}
                            >
                                Load More
                            </button>
                        </div>
                    )}
                </div>
            )}
        </PageContentBlock>
    );
};