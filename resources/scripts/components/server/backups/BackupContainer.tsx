import React, { useContext, useEffect, useState } from "react";
import Spinner from "@/components/elements/Spinner";
import useFlash from "@/plugins/useFlash";
import Can from "@/components/elements/Can";
import CreateBackupButton from "@/components/server/backups/CreateBackupButton";
import FlashMessageRender from "@/components/FlashMessageRender";
import BackupRow from "@/components/server/backups/BackupRow";
import tw from "twin.macro";
import { useTranslation } from "react-i18next";
import getServerBackups, { Context as ServerBackupContext } from "@/api/swr/getServerBackups";
import { ServerContext } from "@/state/server";
import ServerContentBlock from "@/components/elements/ServerContentBlock";
import Pagination from "@/components/elements/Pagination";

const BackupContainer = () => {
    const { t } = useTranslation("server");
    const { page, setPage } = useContext(ServerBackupContext);
    const { clearFlashes, clearAndAddHttpError } = useFlash();
    const { data: backups, error, isValidating } = getServerBackups();

    const backupLimit = ServerContext.useStoreState((state) => state.server.data!.featureLimits.backups);

    useEffect(() => {
        if (!error) {
            clearFlashes("backups");

            return;
        }

        clearAndAddHttpError({ error, key: "backups" });
    }, [error]);

    if (!backups || (error && isValidating)) {
        return <Spinner size={"large"} centered />;
    }

    return (
        <ServerContentBlock title={t("backups")}>
            <FlashMessageRender byKey={"backups"} css={tw`mb-4`} />
            <Pagination data={backups} onPageSelect={setPage}>
                {({ items }) =>
                    !items.length ? (
                        !backupLimit ? null : (
                            <p css={tw`text-center text-sm text-neutral-300`}>
                                {page > 1
                                    ? t("backups_no_more_pages")
                                    : t("backups_none_stored")}
                            </p>
                        )
                    ) : (
                        items.map((backup, index) => (
                            <BackupRow key={backup.uuid} backup={backup} css={index > 0 ? tw`mt-2` : undefined} />
                        ))
                    )
                }
            </Pagination>
            {backupLimit === 0 && (
                <p css={tw`text-center text-sm text-neutral-300`}>
                    {t("backups_limit_zero")}
                </p>
            )}
            <Can action={"backup.create"}>
                <div css={tw`mt-6 sm:flex items-center justify-end`}>
                    {backupLimit > 0 && backups.backupCount > 0 && (
                        <p css={tw`text-sm text-neutral-300 mb-4 sm:mr-6 sm:mb-0`}>
                            {t("backups_count_of", { count: backups.backupCount, limit: backupLimit })}
                        </p>
                    )}
                    {backupLimit > 0 && backupLimit > backups.backupCount && (
                        <CreateBackupButton css={tw`w-full sm:w-auto`} />
                    )}
                </div>
            </Can>
        </ServerContentBlock>
    );
};

export default () => {
    const [page, setPage] = useState<number>(1);
    return (
        <ServerBackupContext.Provider value={{ page, setPage }}>
            <BackupContainer />
        </ServerBackupContext.Provider>
    );
};